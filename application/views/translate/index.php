
<html>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("public/bootstrap-3.3.2/css/bootstrap.min.css");?>">
<script src="<?php echo base_url("public/js/jquery-2.1.3.min.js");?>"></script>
<script
	src="<?php echo base_url("public/AjaxFileUploaderV2.1/ajaxfileupload.js")?>"></script>
</head>
<body>
	<div class="container">
		<form method="post" action="" id="upload_file">
			<div style="margin-top: 50px" class="row">
				<div class="col-xs-6 col-md-4">
					<input type="file" name="userfile" id="userfile">
				</div>
				<div class="col-xs-6 col-md-4">
					<input type="submit" value="Translate" id="btn-translate">
				</div>
				<div class="col-xs-6 col-md-4">
					<input type="button" value="Output excel file">
				</div>
			</div>
		</form>

		<h2>Files</h2>
		<div id="files"></div>
	</div>
</body>
<script>

jQuery.extend({
	handleError: function( s, xhr, status, e ) {
		// If a local callback was specified, fire it
		if ( s.error )
			s.error( xhr, status, e );
		// If we have some XML response text (e.g. from an AJAX call) then log it in the console
		else if(xhr.responseText)
			console.log(xhr.responseText);
	}
});

function refresh_files()
{
	$.get('/bing-translator-exel-file/index.php/translate/files/')
	.success(function (data){
		$('#files').html(data);
	});
}
$('#upload_file').submit(function(e) {
	e.preventDefault();
	
	var file_data = $('#userfile').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data)
    alert(form_data);                             
    $.ajax({
                url: '/bing-translator-exel-file/index.php/translate/translate_file', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(php_script_response){
                	$('#files').html('<p>Reloading files...</p>');
					refresh_files();
					
                }
     });
	
	return false;
});

</script>