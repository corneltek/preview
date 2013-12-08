<?php
namespace Corneltek\Preview\Task;
use Corneltek\ScssRunner;
use Corneltek\SassRunner;

class CompileScssTask extends BaseTask {

    public function run() 
    {
        $this->info("Running scss to compile scss files...");
        $templateDir = $this->config('TemplateDir');
        $staticDir = $this->config('StaticDir');
        $scss = new ScssRunner;

        // default scss directory
        if ( file_exists("$templateDir/$staticDir/scss") ) {
            if ( ! file_exists("$templateDir/$staticDir/css") ) {
                mkdir("$templateDir/$staticDir/css",0755, true);
            }
            $scss->addTarget("$templateDir/$staticDir/scss", "$templateDir/$staticDir/css");
        }

        // extra scss directory
        if ( $paths = $this->config('paths') ) {
            foreach( $paths as $path ) {
                if ( false !== strpos($path, ':') ) {
                    list($src,$dst) = explode(':',$path);
                    $scss->addTarget($src, $dst);
                } else {
                    $scss->addTarget($path);
                }
            }
        }
        if ( $this->config('compass') ) {
            $scss->enableCompass();
        }
        $scss->update($this->config('force'));
    }
}

