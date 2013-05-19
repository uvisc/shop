function ajaxFileUpload()
{
    $.ajaxFileUpload
    (
        {
            url:'doajaxfileupload.php',
            secureuri:false,
            fileElementId:'fileToUpload',
            dataType: 'json',
            beforeSend:function()
            {
                $("#loading").show();
            },
            complete:function()
            {
                $("#loading").hide();
            },
            success: function (data, status)
            {
                if(typeof(data.error) != 'undefined')
                {
                    if(data.error != '')
                    {
                        //alert("1" + data.error);
                    }else
                    {
                        var n=data.msg.split("|");
                        document.getElementById('imageDisplay').style.display = "block";
                        $('#imgUploaded').val(n[0]);
                        $('#imgUploadedWidth').val(n[1]);
                        $('#imgUploadedHeight').val(n[2]);
                        document.getElementById('imageDisplay').innerHTML = "<img src='" + n[0] + "' border='0' width='" + n[1] + "' height='" + n[2] + "' id='elem-wrapper' />";

                        getResizeFunc();

                        //alert(document.getElementById('imageDisplay').innerHTML);
                        //alert("$$$" + $('#imgUploaded').val() + "!!!" + $('#imgUploadedWidth').val() + "@@@" + $('#imgUploadedHeight').val());
                    }
                }
            },
            error: function (data, status, e)
            {
                //alert("2" + e);
            }
        }
    )
    return false;
}

$(function() {
    $("#imageDisplay").draggable(
            { containment: '#map' },
            {
                stop: function(ev, ui)
                {
                    var position = ui.position;
                    var originalPosition = ui.originalPosition;

                    //alert("Pos top: " + position.top + " Pos left: " + position.left + "!!!Original top: " + originalPosition.top + " Original left: " + originalPosition.left);
                    getImagePic(position.top, position.left, 0);
                }
            }
        )

    getResizeFunc();
});

$(function() {
    $("#textDisplay").draggable(
        { containment: '#map' },
        {
            stop: function(ev, ui)
            {
                var position = ui.position;
                var originalPosition = ui.originalPosition;

                //alert("Pos top: " + position.top + " Pos left: " + position.left + "!!!Original top: " + originalPosition.top + " Original left: " + originalPosition.left);
                getImageText(position.top, position.left, 0);
            }
        }
    );
});


$(function ()
{
	$('.expander').simpleexpand();
	//prettyPrint();
	return false;
});

function hexToDeci(num)
{
	res4 = 999;
	args = num;

	k =args.length-1;
	for(var i=0; i<args.length; i++)
	{
	 	thisnum = args.substring(i,i+1) ;
	 	var resd = Math.pow(16,k);

		if(thisnum=='a')
			thisnum=10;
		else if(thisnum=='b')
			thisnum=11;
		else if(thisnum=='c')
			thisnum=12;
		else if(thisnum=='d')
			thisnum=13;
		else if(thisnum=='e')
			thisnum=14;
		else if(thisnum=='f')
			thisnum=15;
		 resd = resd*thisnum;
		 k=k-1;
		 if(res4 == 999)
			{
				res4=resd.toString();
			}
			else
			{
				res4=parseInt(res4)+parseInt(resd);
			}
	}

	return res4;
}

function getImageText(topValue, leftValue, valClick)
{
	var selectedColor = $('#fontColor').val();
	selectedColor = selectedColor.toLowerCase();
	
	var sdx = selectedColor.substring(0,2);
	var redColor = hexToDeci(sdx);
			
	sdx = selectedColor.substring(2,4);
	var greenColor = hexToDeci(sdx);

	sdx = selectedColor.substring(4,6);
	var blueColor = hexToDeci(sdx);

	var parameters = 'type=text&img=cup.jpg&textMessage=' + escape($('#textM').val()) + '&fontFace=' + escape($('#fontFace').val()) + '&fontSize=' + escape($('#fontSize').val()) + '&redColor=' + escape(redColor) + '&greenColor=' + escape(greenColor) + '&blueColor=' + escape(blueColor) + '&top=' + escape(topValue) + '&left=' + escape(leftValue);
				
	$.ajax({
		type: "POST",
		url: "getCustomizedProduct.php",
		data: parameters,
		dataType: "json",
		success: function(oJSON)
		{
			if (oJSON.length > 0)
			{
                if (valClick == 1)
                {
                    document.getElementById('textDisplay').style.top = "0px";
                    document.getElementById('textDisplay').style.left = "0px";
                }
                else
                {
                    document.getElementById('textDisplay').style.top = topValue + " px";
                    document.getElementById('textDisplay').style.left = leftValue + " px";
                }
                //alert(document.getElementById('textDisplay').style.top );

                document.getElementById('textDisplay').style.display = "block";
                document.getElementById('textDisplay').innerHTML = "<span style='color:#" + $('#fontColor').val() + "; font-size:" + $('#fontSize').val() + " px; font-family:" + ($('#fontFace').val()) + "'>" + ($('#textM').val()) + "</span>";

                //alert(document.getElementById('textDisplay').innerHTML);
			}
		}
	});
}

function getImagePic(topValue, leftValue, valClick)
{
    var parameters = 'type=pic&img=cup.jpg&pic=' +  escape($('#imgUploaded').val()) + '&width=' + escape($('#imgUploadedWidth').val()) + '&height=' + escape($('#imgUploadedHeight').val()) + '&top=' + escape(topValue) + '&left=' + escape(leftValue);

    $.ajax({
        type: "POST",
        url: "getCustomizedProduct.php",
        data: parameters,
        dataType: "json",
        success: function(oJSON)
        {
            if (oJSON.length > 0)
            {
                if (valClick == 1)
                {
                    document.getElementById('imageDisplay').style.top = "0px";
                    document.getElementById('imageDisplay').style.left = "0px";
                }
                else
                {
                    document.getElementById('imageDisplay').style.top = topValue + " px";
                    document.getElementById('imageDisplay').style.left = leftValue + " px";
                }
                //alert(document.getElementById('imageDisplay').style.top );

                document.getElementById('imageDisplay').style.display = "block";
                document.getElementById('imageDisplay').innerHTML = "<img src='" + $('#imgUploaded').val() + "' border='0' width='" + $('#imgUploadedWidth').val() + "' height='" + $('#imgUploadedHeight').val() + "' id='elem-wrapper' />";

                getResizeFunc();
            }
        }
    });
}

function getResizeFunc()
{
    var posTop = "";
    var posLeft = "";

    $('#elem-wrapper').resizable({
        containment: '#map',
        aspectRatio: true,
        handles:     'ne, nw, se, sw',
        start: function(event, ui){
            posLeft = $('#imageDisplay').css('left');
            posTop = $('#imageDisplay').css('top');
            //alert(posTop +"###"+posLeft);
        },
        stop: function(event, ui) {
            var width = ui.size.width;
            var height = ui.size.height;

            $('#imgUploadedWidth').val(width);
            $('#imgUploadedHeight').val(height);

            getImagePic(posTop, posLeft, 0);

            //alert(width + "!!!" + height + "@@@" + posTop + "###" + posLeft);
        }
    });
}

function showText()
{
	document.getElementById('imageDetails').style.display = "none";
    document.getElementById('textDetails').style.display = "block";
}

function showImage()
{
    document.getElementById('imageDetails').style.display = "block";
    document.getElementById('textDetails').style.display = "none";
}
