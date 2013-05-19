<?php

	function watermarkText ($SourceFile, $WaterMarkText, $DestinationFile, $filter)
	{ 
		list($width, $height, $imageType) = getimagesize($SourceFile);
		$image_p = imagecreatetruecolor($width, $height);

		//$image = imagecreatefromjpeg($SourceFile);

        if ($image_p)
        {
            switch ($imageType)
            {
                case "1":
                case IMAGETYPE_GIF:
                    $image = imagecreatefromgif($SourceFile);
                    if ($image)
                    {
                        $continue = "Y";
                    }
                    else
                    {
                        $continue = "N";
                    }
                    break;
                case "2":
                case IMAGETYPE_JPEG:
                    $image = imagecreatefromjpeg($SourceFile);
                    if ($image)
                    {
                        $continue = "Y";
                    }
                    else
                    {
                        $continue = "N";
                    }
                    break;
                case "3":
                case IMAGETYPE_PNG:
                    $image = imagecreatefrompng($SourceFile);
                    if ($image)
                    {
                        $continue = "Y";
                    }
                    else
                    {
                        $continue = "N";
                    }
                    break;
                default:
                    $continue = "N";
                    break;
            }

            if ($continue == "Y")
            {
                if (imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height))
                {
                    $black = imagecolorallocate($image_p, $filter->redColor, $filter->greenColor, $filter->blueColor);

                    if ($black)
                    {
                        $font = $filter->fontFace . ".ttf";
                        $font_size = $filter->fontSize;
                        /*
                        $xValue = ($width - (strlen($WaterMarkText) * $font_size))/2;
                        $yValue = $height/2;
                        */

                        if ($filter->left == 0)
                        {
                            $xValue = $filter->left;
                        }
                        else
                        {
                            $xValue = $filter->left - ((584 - $width)/2);
                        }

                        if($filter->top == 0)
                        {
                            $yValue = $filter->top;
                        }
                        else
                        {
                            $yValue = $filter->top + (38 - $font_size);
                        }

                        if (!imagettftext($image_p, $font_size, 0, $xValue, $yValue, $black, $font, $WaterMarkText))
                        //if (!imagettftext($image_p, 10, 0, 10, 20, $black, $font, $WaterMarkText))
                        //if (!imagestring ( $image_p, $font_size, $xValue, $yValue, $WaterMarkText, $black))
                        {
                            echo "imagettftext failed";
                        }
                        else
                        {
    	    	            switch ($imageType)
                            {
                                case "1":
                                case IMAGETYPE_GIF:
                                    if (imagegif ($image_p, $DestinationFile))
                                    {
                                        $final = "Y";
                                    }
                                    else
                                    {
                                        $final = "N";
                                    }
                                break;
                                case "2":
                                case IMAGETYPE_JPEG:
                                    if (imagejpeg ($image_p, $DestinationFile, 100))
                                    {
                                        $final = "Y";
                                    }
                                    else
                                    {
                                        $final = "N";
                                    }
                                break;
                                case "3":
                                case IMAGETYPE_PNG:
                                    if (imagepng ($image_p, $DestinationFile))
                                    {
                                        $final = "Y";
                                    }
                                    else
                                    {
                                        $final = "N";
                                    }
                                break;
                                default:
                                break;
                            }

    	        	        if ($final == "N")
                            {
                                echo "error in final step";
                            }

                            imagedestroy($image);
	    	                imagedestroy($image_p);
                        }
                    }
                    else
                    {
                        echo "imagecolorallocate failed";
                    }
                }
                else
                {
                    echo "imagecopyresampled failed";
                }
            }
            else
            {
                echo "imagecreatefrom failed";
            }
        }
        else
        {
            echo "imagecreatetruecolor failed";
        }
	}

    function watermarkImage($source_file_path, $output_file_path, $filter)
    {
        list($source_width, $source_height, $source_type) = getimagesize($source_file_path);
        list($userImg_width, $userImg_height, $userImg_type) = getimagesize($filter->userImg);
        if ($source_type === NULL)
        {
            return false;
        }

        switch ($source_type)
        {
            case IMAGETYPE_GIF:
                $source_gd_image = imagecreatefromgif($source_file_path);
            break;
            case IMAGETYPE_JPEG:
                $source_gd_image = imagecreatefromjpeg($source_file_path);
            break;
            case IMAGETYPE_PNG:
                $source_gd_image = imagecreatefrompng($source_file_path);
            break;
            default:
            return false;
        }

        $thumb = imagecreatetruecolor($filter->width, $filter->height);
        $source = imagecreatefromjpeg($filter->userImg);
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $filter->width, $filter->height, $userImg_width, $userImg_height);

        $waterMark = $filter->userImg;

        switch ($userImg_type)
        {
            case IMAGETYPE_GIF:
                //$overlay_gd_image = imagecreatefromgif($filter->userImg);
                imagegif($thumb, $waterMark);
                $overlay_gd_image = imagecreatefromgif($waterMark);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($thumb, $waterMark);
                $overlay_gd_image = imagecreatefromjpeg($waterMark);
                //imagecreatefromjpeg($filter->userImg);
                break;
            case IMAGETYPE_PNG:
                imagepng($thumb, $waterMark);
                $overlay_gd_image = imagecreatefrompng($waterMark);
                //$overlay_gd_image = imagecreatefrompng($filter->userImg);
                break;
            default:
                return false;
        }

        $overlay_width = $filter->width;
        $overlay_height = $filter->height;

        if ($filter->left == 0)
        {
            $xValue = $filter->left;
        }
        else
        {
            $xValue = $filter->left - ((584 - $source_width)/2);
        }

        if($filter->top == 0)
        {
            $yValue = $filter->top;
        }
        else
        {
            $yValue = $filter->top;
        }

        imagecopymerge( $source_gd_image, $overlay_gd_image, $xValue, $yValue, 0, 0, $overlay_width, $overlay_height, 100 );
        //imagecopy( $source_gd_image, $overlay_gd_image, $xValue, $yValue, 0, 0, $overlay_width, $overlay_height);

        switch ($source_type)
        {
            case IMAGETYPE_GIF:
                imagegif($source_gd_image, $output_file_path);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($source_gd_image, $output_file_path, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($source_gd_image, $output_file_path);
                break;
            default:
                return false;
        }

        imagedestroy($source_gd_image);
        imagedestroy($overlay_gd_image);
    }
?>