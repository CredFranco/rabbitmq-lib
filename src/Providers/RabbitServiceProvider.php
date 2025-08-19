<?php
    namespace RabbitLib\Providers;

    use Illuminate\Support\ServiceProvider;
    use RabbitLib\Console\MakeMongoModelCommand;

    use RabbitLib\RabbitRepository;

    class RabbitServiceProvider extends ServiceProvider
    {
        public function register()
        {
            $this->app->bind(RabbitRepository::class, function () {
                return new RabbitRepository();
            });
          //  $this->commands([
          //      MakeMongoModelCommand::class,
          //  ]);
        }

        public function boot()
        {
            // Se quiser publicar configs no futuro
        }
    }
