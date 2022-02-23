<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class git_update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'git';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = '/www/wwwroot/laravel-cloud-master';
        $target = '/www/wwwroot/storage/app/Http/Controllers/Home/';
        $file = $this->myScanDir($url);
        $files = $url . '/' . $file;
        copy($files,($target . $file));
        unlink($files);
        exec('git add .');
        exec('git commit -m "server"');
        exec('git push');
        echo '执行成功';
        return 0;
    }

    //获取目录下的文件
    public static function myScanDir($dir)
    {
        $file_arr = scandir($dir);
        $new_arr = [];
        foreach ($file_arr as $item) {

            if ($item != ".." && $item != ".") {

                if (is_dir($dir . "/" . $item)) {
                    $a=array_diff(scandir($dir),array('..','.'));
                    if (!count($a)) {
                        // code...
                    }else{
                        $new_arr[$item] = self::myScanDir($dir . "/" . $item);
                    }

                } else {
                    return $item;
                }
            }
        }
        return $new_arr;
    }
}
