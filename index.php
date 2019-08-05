<?php
class ScanFolder
{
    private $folder;
    private $files;
                            
    public function __construct($path, $path2)
    {
        if ($path2) {
            $path2 = $path.'/'.$path2;
            //echo $path2;
            if ($path2[ strlen($path2) - 1 ] ==  '/') {
                $this->folder = $path2;
            } else {
                $this->folder = $path2 . '/';
            }
                                    
            $this->dir = opendir($path2);
            while (($file = readdir($this->dir)) != false) {
                $this->files[] = $file;
            }
            closedir($this->dir);
        } else {
            if ($path[ strlen($path) - 1 ] ==  '/') {
                $this->folder = $path;
            } else {
                $this->folder = $path . '/';
            }
                                    
            $this->dir = opendir($path);
            while (($file = readdir($this->dir)) != false) {
                $this->files[] = $file;
            }
            closedir($this->dir);
        }
    }

    public function showFolders($path, $path2, $loadfiles)
    {
        //echo $path;
        if (count($this->files) > 2) { /* First 2 entries are . and ..  -skip them */
            natcasesort($this->files);//this function sorts an files (array by using a natural order algorithm)
            $list = '<!DOCTYPE html>
            <html lang="en">
            
            <head>
                <meta charset="utf-8" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <meta name="description" content="" />
                <meta name="author" content="" />
                <link rel="icon" href="../../favicon.ico" />
                <title>SD Team Staging Server</title>
            
                <!-- Bootstrap core CSS -->
                <link href="bootstrap.min.css" rel="stylesheet" />
            
                <style>
                a,
                a:focus,
                a:hover {
                    color: #fff;
                }                
                html,
                body {
                    height: 100%;
                    background-color: #337ab7;
                }
                body {
                    color: #fff;
                    text-align: center;
                    /* text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5); */
                }
                .site-wrapper {
                    display: table;
                    width: 100%;
                    height: 100%; /* For at least Firefox */
                    min-height: 100%;
                    -webkit-box-shadow: inset 0 0 100px rgba(0, 0, 0, 0.5);
                    box-shadow: inset 0 0 100px rgba(0, 0, 0, 0.5);
                }
                .site-wrapper-inner {
                    display: table-cell;
                    vertical-align: top;
                }
                .cover-container {
                    margin-right: auto;
                    margin-left: auto;
                }
                
                /* Padding for spacing */
                .inner {
                    padding: 30px;
                }
                .masthead-brand {
                    margin-top: 10px;
                    margin-bottom: 10px;
                }
                
                .masthead-nav > li {
                    display: inline-block;
                }
                .masthead-nav > li + li {
                    margin-left: 20px;
                }
                .masthead-nav > li > a {
                    padding-right: 0;
                    padding-left: 0;
                    font-size: 16px;
                    font-weight: bold;
                    color: #fff; /* IE8 proofing */
                    color: rgba(255, 255, 255, 0.75);
                    border-bottom: 2px solid transparent;
                }
                .mastfoot {
                    color: #999; /* IE8 proofing */
                    color: rgba(255, 255, 255, 0.5);
                }
                @media (min-width: 768px) {
                    /* Pull out the header and footer */
                    .masthead {
                        /* position: absolute; */
                        top: 0;
                    }
                    .mastfoot {
                        /* position: absolute; */
                        bottom: 0;
                    }
                    /* Start the vertical centering */
                    .site-wrapper-inner {
                        vertical-align: middle;
                    }
                    /* Handle the widths */
                    .masthead,
                    .mastfoot,
                    .cover-container {
                        width: 100%; /* Must be percentage or pixels for horizontal alignment */
                    }
                }
                
                @media (min-width: 992px) {
                    .masthead,
                    .mastfoot,
                    .cover-container {
                        width: 900px;
                    }
                }
                ul.filetree {
                    font-family: Verdana, sans-serif;
                    font-size: 14px;
                    line-height: 33px;
                    padding: 0px;
                    margin: 0px;
                }
                .filetree li.ext_htm {
                    background: url(images/html.png) no-repeat left top;
                }
                .filetree li.ext_html {
                    background: url(images/html.png) no-repeat left top;
                }
                .filetree li.ext_js {
                    background: url(images/script.png) no-repeat left top;
                }
                .filetree li.ext_php {
                    background: url(images/php.png) no-repeat left top;
                } 
                ul.filetree li {
                    list-style: none;
                    padding: 0px 0px 0px 20px;
                    margin: 0px 0px 0px 10px;
                    white-space: nowrap;
                }
                ul.filetree a {
                    color: #fff;
                    text-decoration: none;
                    display: block;
                    padding: 0px 2px 0px 5px;
                    margin-left: 15px;
                }
                ul.filetree a:hover {
                    background: #bdf;
                }                                                                               
                </style>
            
            </head>
            
            <body>
                <div class="site-wrapper">
                    <div class="site-wrapper-inner">
                        <div class="cover-container">
                            <div class="masthead clearfix">
                                <div class="inner">
                                    <!-- <h3 class="masthead-brand">Cover</h3> -->
            
                                    <nav class="navbar navbar-default">
                                        <div class="container-fluid">
                                            <!-- Brand and toggle get grouped for better mobile display -->
                                            <div class="navbar-header">
                                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                                    <span class="sr-only">Toggle navigation</span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                </button>
                                                <a class="navbar-brand font-weight-bold" style="color: #337ab7;" href="#">Custom
                                Server File browser</a>
                                            </div>
            
                                            <!-- Collect the nav links, forms, and other content for toggling -->
                                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">';
                                                
            if ($loadfiles) {
                $list .= '<ul class="nav navbar-nav">
                                                    <!-- class="active" -->
                                                    <li>
                                <a href="index.php" class="font-weight-bold" style="color: #337ab7;">Switch
                                to Folder Mode</a>
                                                    </li>
                                                    <li>
                                                        <a href="/phpmyadmin" class="font-weight-bold" style="color: #337ab7;">phpMyAdmin</a>
                                                    </li>
                                                </ul>';
            } else {
                $list .= '<ul class="nav navbar-nav">
                                    <!-- class="active" -->
                                    <li>
                <a href="index.php?loadfiles=loadfiles" class="font-weight-bold" style="color: #337ab7;">Switch
                to File Mode</a>
                                    </li>
                                    <li>
                                        <a href="/phpmyadmin" class="font-weight-bold" style="color: #337ab7;">phpMyAdmin</a>
                                    </li>
                                </ul>';
            }
            $list .= '</div>
                                            <!-- /.navbar-collapse -->
                                        </div>
                                        <!-- /.container-fluid -->
                                    </nav>
                                    <div style="padding-bottom:10px">
                                        <h1>Custom Server File Browser</h1>
                                    </div>
                                </div>
                            </div>
            
                            <div>
                                <div class="row">';
            if ($loadfiles) {
                $list .= '<ul class="filetree" >';
                // Groups all files... lists all the files in the directory
                foreach ($this->files as $file) {
                    if (file_exists($this->folder . $file) && $file != '.' && $file != '..' && !is_dir($this->folder . $file)) {
                        $ext = preg_replace('/^.*\./', '', $file); //manipulates string to sniff out the file extension
                        //echo $file;
                        $arr=array(
                                "php"=>"php",
                                "html"=>"html"
                            );
                        //checks if the keys exists in the array... more file extensions can be added in the array
                        if (array_key_exists($ext, $arr)) {   //former if ($ext == php || $ext == html){
                            $list .= '<li class="file ext_' . $ext . ' text-left"><a href='.htmlentities($file) .' target="_blank">' . htmlentities($file) . '</a></li>';
                        }
                    }
                }
                $list .= '</ul>            
                <div class="mastfoot">
                <div class="inner">
                    <p>
                        All rights reserved
                        <a href="http://google.com">File Browser ' .date('Y').'</a>
                    </p>
                </div>
            </div>
            </div>
            </div>
            </div>
            </body>
            
            </html>';
                return $list;
            } else {
            
                // Group all folders
                foreach ($this->files as $file) {
                    if (file_exists($this->folder . $file) && $file != '.' && $file != '..' && is_dir($this->folder . $file)) {
                        //header('Content-Type: image/png');
                        
                        $list .= '<div class="col-xs-6 col-md-3"><div class="thumbnail"><img src="images/folder1.png" alt="folder"/><div class="caption"><h5>'. htmlentities($file) .'</h5><p><a href="index.php?dir=' . htmlentities($file) . '" class="btn btn-primary" role="button" target="_blank">View</a></p></div></div></div>';
                    }
                }
                $list .= '</div>
            </div>
            
            <div class="mastfoot">
                <div class="inner">
                    <p>
                        All rights reserved
                        <a href="http://google.com">File Browser' .date('Y').'</a>
                    </p>
                </div>
            </div>
            </div>
            </div>
            </div>
            </body>
            
            </html>';
                return $list;
            }
        }
    }
    public function showAllFiles($path2)
    {
        $a = "location:";
        $b = "/public";
        $url1= $a."../".$path2.$b;
        $url = $a."../".$path2;
        //print_r($this->files);
        //echo $path2;
        foreach ($this->files as $file) {
            if ($file == 'public') {
                //echo "yes";
                //header($url1);
                header($url1);
                exit;
            } else {
                header($url);
            }
        }
    }
}

$path2 = urldecode($_REQUEST['dir']);
$loadfiles = urldecode($_REQUEST['loadfiles']);
 //$tree2 = new ScanFolder($path2);
$path = $_SERVER['DOCUMENT_ROOT']; //this gets the root of our document e.g '/Users/tosmak/Sites'

//creates an object tree of the class ScanFiles
$tree = new ScanFolder($path, $path2);

if ($loadfiles) {
    echo $tree->showFolders($path, $path2, $loadfiles);
    return;
}

                          
if ($path2) {
    echo $tree->showAllFiles($path2);
    //echo "hi me";
    return;
} else {
    //calls method showFiles to perform it's action on the class object
    echo $tree->showFolders($path, $path2, $loadfiles);
    //echo $tree2->showAllFiles($path2);
    return;
}
