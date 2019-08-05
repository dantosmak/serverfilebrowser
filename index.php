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
                    background: url("data:image/jpg;base64,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") no-repeat left top;
                }
                .filetree li.ext_html {
                    background: url("data:image/jpg;base64,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") no-repeat left top;
                }
                .filetree li.ext_js {
                    background: url(images/script.png) no-repeat left top;
                }
                .filetree li.ext_php {
                    background: url("data:image/jpg;base64, iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAGeklEQVR42rWXbUxTVxjH//dCS1uKira9dUBbEHkRBzgXYkSzbMvUBYz4adHsg6ImZl+cLtmi7oPL5octxixzm0tcotmbyzYXdSZbzNxMFDSbyngvMF4LWChgEWhpb+/tnnNKKyAy3eAkJ+fe03Pu8zvP66lw69Ytl9ksSeFwGKxFhqnPU8epzw/2TR2jz7G9Dz7I5wVBQF9fb7/Q0tLi7nClSEsWixi6F0IopPINqhKGwSCgqdmH4fsyFJpXFIX/rijUQ/Q8MbL30MTvbB2fjz0rE3vZGmVir4q0ND327bN6OICrN0VKTYlHT6+MpdY4aOIBz4CMQFBFS4uPwOYRoLm52d3uSpXkYJgLNS0RSUWRDV2uwCRB8wggSRmSqkYsP8Xe4ajtIlbkNlUjoxqe/T3a1envE2s0GoGABj1CU1OTOzMzUxJFEbO1yU4W7f/nnWno7t27TwYwF4KjPRQKURT0PR7AXAmOvjPhbOQATqfTvXz58scC+K+nnT4XDAYRFxcHt9v97wDRTX6/Cu+wSjlBgSyDO5I6KTHFU+gmGaknAXrdo8HZ6Zn9YwCNjY3urKysGQHueUMUikEEAuwDAgkQodMJtJm6GCQVtkGSHFBUHUGF4fMR4IhKzwrlEhW2VBHJycKkiFA5AGsMgDvhTAAs8TQ6/VzQwgVxM2pGlvvwV9U1rFu/lQAfXsPC2t0nY2wsiJV58VicLMSERwF6e3s9QkNDgzs7OzsGUFc/is7OACwWDRITRXr+k9St8ty9YIEZiUYHP+2wtxZOZxWysvLIpiGkphXSfAKt86C/v5PnEI1GiyWmZaipFeCwC3h6pWYKQE9Pz1SA+oYRVN70Ylm6gS8yGPy4eOFT2Gx2Uq8PAwMeFBdvgt6Qh27XL5SmncgvKEKTsxrLMnPIHM/D038dTU3VlOns6OhoI9+IR/G6Pai4MYb1xXqCSHgYICcnR2KTx463YuFCDcxmLV8kCi5c+ukUtm0/DEHU4eL595GTWwiHYxOuX/sEdns2JOuLcDZ+SdpKRkpaCVqaz0KXoEeqrQzBQD3OnD6OlzYexOCQGVqtgL17TAQlcIDu7m6PUF9f787NzZXuj4Tw7tFGGPRxSE9PJFUCvrFK3Kj8GWVb92LA043Ll79DaelOWJcW4vNT+1BSugsmcwHOfX8IRUUbSehzOP/j21ixopBUn4dzP3yM27dv4q2DV6nQBfmhdu2QYLVqOYDL5XoAwOx48HANDzGDIQ5mUwKGBr/FtWu/xey2alURCgr3Ujy4cfr0IZTv+oBOZcRnJ18jLR0ij7fjxEe7yQf60dXVxYUceOMExnzPTDhmGAf2p2DRQh3/jdZ4hLq6Op4Jma2++roB1yvG+OLkZA1uVh5AXt6zsEgFBJVMkZiOUdKU1arA6+2guRzEa2Saa6MPOjA62oSj772KI++cptMNYOlThRgaSuLaDAQUZGfFYeeOTDB/Yz0GYLfbJRajXu8wvjnbjYYGGTnZRhw5sgbl5UfhH18TiX3q7GMsIqK3HUVhyYWXTsoNl3Hhwkm8vv9Xsq+PokCMmNKnwJYmYvt2K8GbIv4lsgjrjAA4HA4OwNrg4CB+v+pGQ72CBF0IIyMsYQRmLVQsgkVRQG5uIhK0YXR2Re4NwWDkXrB2rR4vvmChKDFz+ChAR0eHR6itrXWnp6fH7oSssZBzdffh9q37uHPHTwDyxKaIFtgY6zwrRjQT0QjLhCoWLRJRUKDH6tVGCmMLpeikadAi2tvbIwAZGRlTAKJ5m4EMDw/D4xnF361+yt0yOZhMWqF6QDcomRIbu75ptSIMiQIsZg2FpQaZy/R0WiMlrgUwGo2xU09ubI4D1NTUcCecDjAdZnx8nFcx1qPllJmNnYR9jDmxRqMhGC3VCx1X/WyN7eEmYACsGs4G8KSNAdLpKDklcsgo7HQZVVVVfwjV1dW8GM01AGU5qhNZ/KRRE0RHBnOTGsl8mQOwWjDXABRiINPGBEc7M01lZeUlk8n0Sn5+vm9eAJiQtrY2kHPH/gWxzvynoqLiC5vNVk7CuZNwAFaM5loDra2tFH62GIDf7wflnA83bNiwf/LaeQFgGqB/XEhJSeH2HhkZCVPNeXPLli3Hpq+NAcyZ9AkNMACLxUJ3iAGF/GH35s2bz8y0lgOwajgfALIs++nqva2kpOTCo9YKV65c4cVoLgGYCcjeXiq5pWVlZRWzrf0HE9NTWbpAfYgAAAAASUVORK5CYII=") no-repeat left top;
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
                        $list .= '<div class="col-xs-6 col-md-3"><div class="thumbnail"><img src="data:image/jpg;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAAA3NCSVQICAjb4U/gAAAACXBIWXMAAA9MAAAPTAEzJ+tuAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAAQhQTFRF//////8AgICA/8xm/6pV769groZe9LFk97Vj+LdiuIhZ+bdks4hc9rNj97Vj+LZitIhc+LRitolc9rRj97Vj97ZitYhc+LRi9rRj9rZjtYha97Vj97ZjtYlb+LRi9rVj9rVitYhb97Vj97Vj97Vj+LRitYhb9rVj46dg36Vh97Vj97Vj1qBftYhb26ty97Vi3rF8tYhbtYhc97VktYhb97Vj97Vj6Mmm97Vj97VitYhb97Vj97Vk97VjtYhb97VjtYhbtopetotgtoxit4tft49muI5kuJJsupFpvZhywZx5wbamwqGAxaWFx8Czx8rHyKaEyK+UyLGX0bWZ5Ofl5+zt97Vj////0Az+ZgAAAEB0Uk5TAAECBQkQExcfJysuLzY+RktOUFVdZWdtdHZ8fISKjJCUmJufo6uwsrS4usLDyMnKy8zO0tjY2drh6e3w9vv9/iFHdDoAAAFMSURBVFiF7dZpN0JRFIfxp0klJEVFUt0SuYQMRZF5nqfv/028cF3EwtmbtVqW5/3/93KfA11R7+LSm2b7DIF8u6MFrxJoj2iBtR4l0M5rgY3Roa8a9H4GfKdxLTD5D3QC2ycG7X0A7FwYdPALwP7VuUHXh++AozujTn8c2Dq+NepstwO4fDDs5g8BE5ZlTdn23Kph87Y9bVnWBPV7VXUqOqBCTgfkSOqAJFEdECWkA0J4mpp90wM1DVADShqgBGQ0QAZIaIAE0K8B+oGABggANOT7BgAzcmAGgIIcKACQkgMpAGJyIAZAWA6EAfC1pPuW7+kor0iBFeeql6VA2QGyUiDrAMNSYNgBBqTAgAMEpUDw+W1cl+3X3ce1KgOqLlCUAUUXGJMBYy4QlwFxF4jIgIgL+Dcl+02/C8h+GfWXveyXUXkFpJcFpemOHgGInfLnvrsmjwAAAABJRU5ErkJggg==" alt="folder"/><div class="caption"><h5>'. htmlentities($file) .'</h5><p><a href="index.php?dir=' . htmlentities($file) . '" class="btn btn-primary" role="button" target="_blank">View</a></p></div></div></div>';
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
