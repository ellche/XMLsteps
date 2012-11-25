<?php

    $errorCode = $_GET['err'];    
    $mimeType = $_GET['mime'];
    
    define("UPLOAD_ERR_EMPTY", 5);
    define("UPLOAD_ERR_NO_XML", 9);
    
    $uploadErrors = array(
    UPLOAD_ERR_OK         => 'There is no error, the file uploaded with success.',
    UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
    UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
    UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded.',
    UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
    UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
    UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
    UPLOAD_ERR_EXTENSION  => 'File upload stopped by extension.',
    UPLOAD_ERR_EMPTY      => 'The file that you uploaded is empty.',
    UPLOAD_ERR_NO_XML     => 'The file that you uploaded did not contain valid XML code.'
    );  
  
    if ($errorCode != null)
    {
        $error = $uploadErrors[$errorCode];
        
        $mimeTypeError = '';
        if($mimeType != null)
        {
            $mimeTypeError = 'The type of the uploaded file is '.$mimeType.'<br>';
        }
                
        echo '<h1>Error</h1>'.
              $error.'<br>'.
              $mimeTypeError.
             '<a href="uploadform.html">Click here to upload a new file.</a>';
    }
    else
    {
        //go back to uploadform
        header('Location: uploadform.html');
        exit;
    }
    
?> 