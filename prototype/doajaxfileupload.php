<?php
	$error = "";
	$msg = "";
    $width = "";
    $height = "";
	$fileElementName = 'fileToUpload';
	//echo "msg : " . $_FILES[$fileElementName]['error'];

    if(!empty($_FILES[$fileElementName]['error']))
	{
		switch($_FILES[$fileElementName]['error'])
		{
			case '1':
				$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				break;
			case '2':
				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				break;
			case '3':
				$error = 'The uploaded file was only partially uploaded';
				break;
			case '4':
				$error = 'No file was uploaded.';
				break;
			case '6':
				$error = 'Missing a temporary folder';
				break;
			case '7':
				$error = 'Failed to write file to disk';
				break;
			case '8':
				$error = 'File upload stopped by extension';
				break;
			case '999':
			default:
				$error = 'No error code available';
		}
	}
    else
    {
        if(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
        {
            $error = 'No file was uploaded..';
        }
        else
        {
            $target_path = "customizedProduct/userImage/";

            $target_path = $target_path . basename( $_FILES['fileToUpload']['name']);
            $ratio = 1;

            if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_path))
            {
                list($imgWidth, $imgHeight) = getimagesize($target_path);
                if ($imgWidth > $imgHeight)
                {
                    $ratio = 100/$imgWidth;
                }
                else
                {
                    if ($imgWidth < $imgHeight)
                    {
                        $ratio = 100/$imgHeight;
                    }
                    else
                    {
                        $ratio = 100/$imgWidth;
                    }
                }

                $newWidth = ($ratio * $imgWidth) . "px";
                $newHeight = ($ratio * $imgHeight) . "px";

                $msg = $target_path . "|" . $newWidth . "|" . $newHeight;
            }
            else
            {
                $error = "There was an error uploading the file, please try again!";
            }
            //$msg .= " File Name: " . $_FILES['fileToUpload']['name'] . ", ";
            //$msg .= " File Size: " . @filesize($_FILES['fileToUpload']['tmp_name']);
        }
    }

    echo "{";
    echo				"error: '" . $error . "',\n";
    echo				"msg: '" . $msg . "'\n";
    echo "}";
?>