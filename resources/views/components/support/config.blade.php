@use(\App\Enums\Framework)

@props([
    'framework' => null,
    'port' => 2525,
])

<div class="space-y-2 text-sm dark:text-neutral-300">
    @switch($framework)
        {{-- LARAVEL CONFIG --}}
        @case (Framework::Laravel)
            <span>Add to your .env file:</span>

            <x-support.code>
                MAIL_MAILER=smtp
                MAIL_HOST=127.0.0.1
                MAIL_PORT={{ $port }}
                MAIL_PASSWORD=null
                MAIL_ENCRYPTION=null
            </x-support.code>
        @break

        {{-- SYMFONY CONFIG --}}
        @case(Framework::Symfony)
            <span>Add to your .env file:</span>

            <x-support.code>
                MAILER_URL=smtp://127.0.0.1:{{ $port }}?encryption=null&auth_mode=login&password=
            </x-support.code>
        @break

        {{-- WORDPRESS CONFIG --}}
        @case(Framework::Wordpress)
            <x-support.code>
                function phost($phpmailer) {
                &nbsp;&nbsp;&nbsp;&nbsp;$phpmailer->isSMTP();
                &nbsp;&nbsp;&nbsp;&nbsp;$phpmailer->Host = '127.0.0.1';
                &nbsp;&nbsp;&nbsp;&nbsp;$phpmailer->SMTPAuth = true;
                &nbsp;&nbsp;&nbsp;&nbsp;$phpmailer->Port = {{ $port }};
                &nbsp;&nbsp;&nbsp;&nbsp;$phpmailer->Password = '';
                }

                add_action('phpmailer_init', 'phost');
            </x-support.code>
        @break

        {{-- YII CONFIG --}}
        @case(Framework::Yii)
            <span>Add to your config file:</span>

            <x-support.code>
                'components' => [
                &nbsp;&nbsp;&nbsp;&nbsp;...
                &nbsp;&nbsp;&nbsp;&nbsp;'mail' => [
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'class' => 'yii\swiftmailer\Mailer',
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'transport' => [
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'class' => 'Swift_SmtpTransport',
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'host' => '127.0.0.1',
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'password' => '',
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'port' => '{{ $port }}',
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'encryption' => 'tls',
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;],
                &nbsp;&nbsp;&nbsp;&nbsp;],
                &nbsp;&nbsp;&nbsp;&nbsp;...
                ],
            </x-support.code>
        @break

        {{-- RAILS CONFIG --}}
        @case(Framework::Rails)
            <span>In config/environments/*.rb specify ActionMailer defaults for your development or staging servers:</span>

            <x-support.code>
                config.action_mailer.delivery_method = :smtp
                config.action_mailer.smtp_settings = {
                &nbsp;&nbsp;&nbsp;&nbsp;:user_name => 'Mailbox-Name',
                &nbsp;&nbsp;&nbsp;&nbsp;:password => '',
                &nbsp;&nbsp;&nbsp;&nbsp;:address => '127.0.0.1',
                &nbsp;&nbsp;&nbsp;&nbsp;:domain => '127.0.0.1',
                &nbsp;&nbsp;&nbsp;&nbsp;:port => '{{ $port }}',
                &nbsp;&nbsp;&nbsp;&nbsp;:authentication => :plain
                }
            </x-support.code>
        @break
    @endswitch

</div>
