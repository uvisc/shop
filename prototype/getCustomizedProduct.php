<?php
    require_once('editImage.php');

    $SourceFile = 'products/images/';
    $DestinationFile = 'customizedProduct/images/';
    $WaterMarkText = '';
    $filter = array();

    if ($_POST['type'] == "text")
    {
        $newImage = explode(".", $_POST['img']);
        $randomInt = rand();
        $SourceFile .= $_POST['img'];
        $DestinationFile .= $newImage[0] . "_" . $randomInt . "." . $newImage[1];
        $WaterMarkText = $_POST['textMessage'];
        $filter = NULL;

        $filter->fontSize = $_POST['fontSize'];
        $filter->fontFace = $_POST['fontFace'];
        $filter->redColor = $_POST['redColor'];
        $filter->greenColor = $_POST['greenColor'];
        $filter->blueColor = $_POST['blueColor'];
        $filter->top = $_POST['top'];
        $filter->left = $_POST['left'];

        watermarkText ($SourceFile, $WaterMarkText, $DestinationFile, $filter);

        $finalDiv .= "<img src='" . $DestinationFile . "' border='0' />";
    }
    else
    {
        if ($_POST['type'] == "pic")
        {
            $newImage = explode(".", $_POST['img']);
            $randomInt = rand();
            $SourceFile .= $_POST['img'];
            $DestinationFile .= $newImage[0] . "_" . $randomInt . "." . $newImage[1];
            $filter = NULL;

            $filter->width = $_POST['width'];
            $filter->height = $_POST['height'];
            $filter->userImg = $_POST['pic'];
            $filter->top = $_POST['top'];
            $filter->left = $_POST['left'];

            watermarkImage ($SourceFile, $DestinationFile, $filter);

            $finalDiv .= "<img src='" . $DestinationFile . "' border='0' />";
        }
    }

    $finalDiv = json_encode($finalDiv);
    header("content-type: application/json");
    echo $finalDiv;
?>