@servers(['localhost' => '127.0.0.1', 'production' => 'ormalex.beget.tech'])

@task('deploy', ['on' => 'workers'])
cd /home/user/example.com
php artisan queue:restart
@endtask
