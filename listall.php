<?php 

class ScanAllFolder {

    private $folder;
    private $files;

    
    function __construct($path, $path2) {
        if( $path[ strlen( $path ) - 1 ] ==  '/' )
        $this->folder = $path;
        else
        $this->folder = $path . '/';
              
        $this->dir = opendir( $path );
        while(( $file = readdir( $this->dir ) ) != false )
            $this->files[] = $file;
        closedir( $this->dir );
    }

    function showAllFiles($path2){
        
            foreach( $this->files as $file ) {
                if($file == 'public'){
                    $a = "location:";
                    $b = "/public";
                    //echo $path2;
                    $url = $a."../".$path2.$b;
                    header($url);
                    return;
                }else{
                    $a = "location:";
                    $url = $a."../".$path2;
                    header($url);
                }
            }
    }


}

$path = urldecode( $_REQUEST['dir'] );

$path2 = urldecode( $_REQUEST['n'] );


$tree = new ScanAllFolder( $path , $path2);
echo $tree->showAllFiles($path2);
?>