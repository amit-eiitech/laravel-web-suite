<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', '');
        $this->migrator->add('general.logo_path', null);
        $this->migrator->add('general.favicon_path', null);

        $this->migrator->add('company.company_name', '');
        $this->migrator->add('company.representative_name', null);
        $this->migrator->add('company.postal_code', null);
        $this->migrator->add('company.prefecture', null);
        $this->migrator->add('company.address', null);
        $this->migrator->add('company.registration_number', null);

        $this->migrator->add('contact.public_email', null);
        $this->migrator->add('contact.phone', null);
        $this->migrator->add('contact.business_hours', null);

        $this->migrator->add('social.x_url', null);
        $this->migrator->add('social.facebook_url', null);
        $this->migrator->add('social.instagram_url', null);
        $this->migrator->add('social.linkedin_url', null);
        $this->migrator->add('social.youtube_url', null);

        $this->migrator->add('localization.default_locale', 'ja');
        $this->migrator->add('localization.timezone', 'Asia/Tokyo');
        $this->migrator->add('localization.date_format', 'Y年m月d日');

        $this->migrator->add('seo.default_title', null);
        $this->migrator->add('seo.default_description', null);
        $this->migrator->add('seo.default_og_image', null);
        $this->migrator->add('seo.allow_indexing', true);

        $this->migrator->add('notifications.admin_emails', []);
        $this->migrator->add('notifications.contact_auto_reply_enabled', true);
    }
};
