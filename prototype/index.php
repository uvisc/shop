<?php
    session_start();
    $imgWidth = "384";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <link type="text/css" href="css/style.css" rel="stylesheet" />
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="css/jquery.ui.resizable.css" />
		<!--<link rel="stylesheet" type="text/css" href="css/ui.theme.css">-->
	</head>
	<body>
        <table width="80%" align="center">
			<tr>
				<td align="center" width="60%" valign="top">
					<div id="productImage">
                        <div id="map">
                            <div id="textDisplay" class="ui-widget-content">
                            </div>
                            <div id="imageDisplay" class="ui-widget-content">
                            </div>
                            <input type="hidden" name="imgUploaded" id="imgUploaded" value="" />
                            <input type="hidden" name="imgUploadedHeight" id="imgUploadedHeight" value="" />
                            <input type="hidden" name="imgUploadedWidth" id="imgUploadedWidth" value="" />
                        </div>
                        <!--<img src="products/images/cup.png" border="0" />-->
                    </div>
				</td>
				<td align="left" width="40%" valign="top">
					<div id="demo-with-image">
                        <a class="expander" href="#">Customize It!</a>
						<div class="content">
							<div class="buttons">
								<span class="linkButton"><a href="#" onclick="showImage()">Add Image</a></span>
								<span class="linkButton"><a href="#" onclick="showText()">Add Text</a></span>
							</div>
							<br />
                            <div class="imageDetails" id="imageDetails" style="display:none">
                                <img id="loading" src="images/loading.gif" style="display:none;">
                                <form name="form" action="" method="POST" enctype="multipart/form-data">
                                    <input id="fileToUpload" type="file" size="45" name="fileToUpload" class="input"><a href="#" onclick="return ajaxFileUpload();">Upload</a>
                                </form>
                            </div>
							<div class="textDetails" id="textDetails" style="display:none">
                                <textarea name="textM" id="textM" rows="5" cols="30"></textarea><a href="#" onclick="getImageText(0,0,1); return false;">Go</a>
                                <br />
                                <select name="fontFace" id="fontFace">
                                    <option value="arial">Arial</option>
                                </select>
                                <select name="fontSize" id="fontSize">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                    <option value="60">60</option>
                                </select>
                                <select name="fontColor" id="fontColor">
                                    <option style="color:red;font-weight: bold;" value="FF0000">RED</option>
                                    <option style="color:blue;font-weight: bold;" value="0040FF">BLUE</option>
                                </select>
							</div>
						</div>
					</div>
				</td>
			</tr>
		</table>

        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <script type="text/javascript" src="js/simple-expand.js"></script>
        <script type="text/javascript" src="js/ajaxfileupload.js"></script>
        <script src="js/common.js" type="text/javascript"></script>
    </body>
</html>