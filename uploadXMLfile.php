<?php

/*     
    more here:
    http://www.php.net/manual/en/features.file-upload.post-method.php
    http://www.php.net/manual/en/features.file-upload.errors.php
    http://www.php.net/manual/en/features.file-upload.common-pitfalls.php
    
    http://www.w3schools.com/php/php_file_upload.asp
    
    http://www.php.net/manual/en/simplexml.examples-basic.php
    
            /*
            first save file
            The file will be deleted from the temporary directory at the end of the request if it has not been moved away or renamed.
            Also, files uploaded by other users should not be accessible
            So, maybe remane the file to something_usersessionID ?
            and delete it in the end of the session?
            and delete also all other files, created for download on the filtering page
            */ 
    


    session_start();

    $userFile = $_FILES['userFile'];    
    define("UPLOAD_ERR_EMPTY", 5);
    define("UPLOAD_ERR_NO_XML", 9);

    checkUploadErrors();
    checkFileType();
    checkXMLvalid();
    
//  get result and put it in session!
      
//    header('Location: filterpage.php');
//    exit;    
    
    //TODO set a custom limit for size?
    function checkUploadErrors()
    {
        global $userFile;
         
        if($userFile['size'] == 0 && $userFile['error'] == 0)
        {
            $userFile['error'] = UPLOAD_ERR_EMPTY;
        }
        
        if ($userFile['error'] > 0 || $userFile['size'] == 0)
        {        
            showError();
        }        
    }
    
    function checkFileType()
    {
        global $userFile;
        $userFileExtension = end(explode('.', $userFile['name']));
        $userFileExtension = strtolower($userFileExtension);
        
        $allowedMimeTypes = array('text/xml','application/xml','application/x-xml');
        
        $fileName = $userFile['tmp_name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $userFileMime = finfo_file($finfo, $fileName);
        finfo_close($finfo);
               
        if($userFileExtension != 'xml' || !in_array($userFileMime, $allowedMimeTypes)) 
        {  
            $userFile['error'] = UPLOAD_ERR_NO_XML;
            $userFile['type'] = $userFileMime;
            showError();
        }
    }
 
    function checkXMLvalid()
    {
        global $userFile;
        $fileName = $userFile['tmp_name'];
        $root = simplexml_load_file($fileName);
        if ($root === false)
        {
            $userFile['error'] = UPLOAD_ERR_NO_XML;
            showError();
        }
        else
        {
			echo 'xml ok';
            //print_r($root);
//            $_SESSION['root'] = $root;
            $_SESSION['ra'] = 'raka';
           header('Location: filterpage.php');
            exit;
        }
    }    
    
    function showError()
    {        
        global $userFile;      
        
        $errorCode = $userFile['error'];
        $mimeType = $userFile['type'];
        $mimeParameter = (empty($mimeType)) ? "" : "&mime=$mimeType" ;
        header("Location: errorpage.php?err=$errorCode".$mimeParameter);
        exit;
    }
?> 