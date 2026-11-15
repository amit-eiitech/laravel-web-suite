<?php

namespace Eii\WebSuite\Filament;

use Eii\WebSuite\WebSuite;
use Filament\Contracts\Plugin;
use Filament\Panel;

class WebSuitePlugin implements Plugin
{
    protected ?array $customResources = null;
    protected ?array $customPages = null;

    protected bool $includeNews = true;
    protected bool $includeEvents = true;
    protected bool $includeRecruitment = true;
    protected bool $includeBlog = false;
    protected bool $includeFaqs = true;
    protected bool $includeCategories = true;
    protected bool $includeContact = true;
    protected bool $includeSeo = true;
    protected bool $includeSettings = true;
    protected bool $showBulkActions = true;

    public function __construct()
    {
        $this->includeNews = true;
        $this->includeEvents = true;
        $this->includeRecruitment = true;
        $this->includeBlog = false;
        $this->includeFaqs = true;
        $this->includeCategories = true;
        $this->includeContact = true;
        $this->includeSeo = true;
        $this->includeSettings = true;
        $this->showBulkActions = true;
    }

    /**
     * Instantiate the plugin, optionally passing modules to enable.
     *
     * @param array<int|string, string|bool>|null $modules
     */
    public static function make(?array $modules = null): static
    {
        $plugin = app(static::class);

        if ($modules !== null) {
            $plugin->modules($modules);
        }

        return $plugin;
    }

    public function getId(): string
    {
        return 'eii-web-suite';
    }

    public function register(Panel $panel): void
    {
        config(['eii-web-suite.filament.show_bulk_actions' => $this->showBulkActions]);

        $panel
            ->resources($this->getResources())
            ->pages($this->getPages());
    }

    public function boot(Panel $panel): void
    {
        //
    }

    /**
     * Select which modules to enable in the admin panel.
     *
     * Supports both list format (whitelisting only specified modules):
     *   ->modules(['news', 'events', 'blog', 'contact'])
     *
     * And associative toggle format:
     *   ->modules(['news' => true, 'events' => false, 'blog' => true])
     *
     * @param array<int|string, string|bool> $modules
     */
    public function modules(array $modules): static
    {
        if (array_is_list($modules)) {
            $this->includeNews = in_array('news', $modules, true);
            $this->includeEvents = in_array('events', $modules, true);
            $this->includeRecruitment = in_array('recruitment', $modules, true);
            $this->includeBlog = in_array('blog', $modules, true);
            $this->includeFaqs = in_array('faqs', $modules, true);
            $this->includeCategories = in_array('categories', $modules, true);
            $this->includeContact = in_array('contact', $modules, true);
            $this->includeSeo = in_array('seo', $modules, true);
            $this->includeSettings = in_array('settings', $modules, true) || $this->includeSettings;

            return $this;
        }

        foreach ($modules as $module => $enabled) {
            $this->setModuleState((string) $module, (bool) $enabled);
        }

        return $this;
    }

    /**
     * Alias for modules().
     *
     * @param array<int|string, string|bool> $modules
     */
    public function only(array $modules): static
    {
        return $this->modules($modules);
    }

    /**
     * Enable all available modules.
     */
    public function allModules(): static
    {
        $this->includeNews = true;
        $this->includeEvents = true;
        $this->includeRecruitment = true;
        $this->includeBlog = true;
        $this->includeFaqs = true;
        $this->includeCategories = true;
        $this->includeContact = true;
        $this->includeSeo = true;
        $this->includeSettings = true;

        return $this;
    }

    /**
     * Disable all content modules.
     */
    public function withoutModules(): static
    {
        $this->includeNews = false;
        $this->includeEvents = false;
        $this->includeRecruitment = false;
        $this->includeBlog = false;
        $this->includeFaqs = false;
        $this->includeCategories = false;
        $this->includeContact = false;
        $this->includeSeo = false;

        return $this;
    }

    protected function setModuleState(string $module, bool $enabled): void
    {
        match ($module) {
            'news' => $this->includeNews = $enabled,
            'events' => $this->includeEvents = $enabled,
            'recruitment' => $this->includeRecruitment = $enabled,
            'blog' => $this->includeBlog = $enabled,
            'faqs', 'faq' => $this->includeFaqs = $enabled,
            'categories', 'category' => $this->includeCategories = $enabled,
            'contact' => $this->includeContact = $enabled,
            'seo' => $this->includeSeo = $enabled,
            'settings' => $this->includeSettings = $enabled,
            default => null,
        };
    }

    // --- Fluent Positive Helpers ---

    public function withNews(bool $condition = true): static
    {
        $this->includeNews = $condition;

        return $this;
    }

    public function withEvents(bool $condition = true): static
    {
        $this->includeEvents = $condition;

        return $this;
    }

    public function withRecruitment(bool $condition = true): static
    {
        $this->includeRecruitment = $condition;

        return $this;
    }

    public function withBlog(bool $condition = true): static
    {
        $this->includeBlog = $condition;

        return $this;
    }

    public function withFaqs(bool $condition = true): static
    {
        $this->includeFaqs = $condition;

        return $this;
    }

    public function withCategories(bool $condition = true): static
    {
        $this->includeCategories = $condition;

        return $this;
    }

    public function withContact(bool $condition = true): static
    {
        $this->includeContact = $condition;

        return $this;
    }

    public function withSeo(bool $condition = true): static
    {
        $this->includeSeo = $condition;

        return $this;
    }

    public function withSettings(bool $condition = true): static
    {
        $this->includeSettings = $condition;

        return $this;
    }

    public function withBulkActions(bool $condition = true): static
    {
        $this->showBulkActions = $condition;

        return $this;
    }

    // --- Fluent Negative Helpers ---

    public function withoutNews(bool $condition = true): static
    {
        $this->includeNews = ! $condition;

        return $this;
    }

    public function withoutEvents(bool $condition = true): static
    {
        $this->includeEvents = ! $condition;

        return $this;
    }

    public function withoutRecruitment(bool $condition = true): static
    {
        $this->includeRecruitment = ! $condition;

        return $this;
    }

    public function withoutBlog(bool $condition = true): static
    {
        $this->includeBlog = ! $condition;

        return $this;
    }

    public function withoutFaqs(bool $condition = true): static
    {
        $this->includeFaqs = ! $condition;

        return $this;
    }

    public function withoutCategories(bool $condition = true): static
    {
        $this->includeCategories = ! $condition;

        return $this;
    }

    public function withoutContact(bool $condition = true): static
    {
        $this->includeContact = ! $condition;

        return $this;
    }

    public function withoutSeo(bool $condition = true): static
    {
        $this->includeSeo = ! $condition;

        return $this;
    }

    public function withoutSettings(bool $condition = true): static
    {
        $this->includeSettings = ! $condition;

        return $this;
    }

    public function withoutBulkActions(bool $condition = true): static
    {
        $this->showBulkActions = ! $condition;

        return $this;
    }

    // --- Custom Resource and Page Overrides ---

    /**
     * Override or specify exactly which resources to register.
     *
     * @param array<class-string> $resources
     */
    public function resources(array $resources): static
    {
        $this->customResources = $resources;

        return $this;
    }

    /**
     * Override or specify exactly which pages to register.
     *
     * @param array<class-string> $pages
     */
    public function pages(array $pages): static
    {
        $this->customPages = $pages;

        return $this;
    }

    /**
     * @return array<class-string>
     */
    public function getResources(): array
    {
        if ($this->customResources !== null) {
            return $this->customResources;
        }

        return array_values(array_filter([
            $this->includeNews ? \Eii\WebSuite\Filament\Resources\News\NewsResource::class : null,
            $this->includeEvents ? \Eii\WebSuite\Filament\Resources\Event\EventResource::class : null,
            $this->includeRecruitment ? \Eii\WebSuite\Filament\Resources\JobPost\JobPostResource::class : null,
            $this->includeBlog ? \Eii\WebSuite\Filament\Resources\BlogPost\BlogPostResource::class : null,
            $this->includeFaqs ? \Eii\WebSuite\Filament\Resources\Faq\FaqResource::class : null,
            $this->includeCategories ? \Eii\WebSuite\Filament\Resources\Category\CategoryResource::class : null,
            $this->includeContact ? \Eii\WebSuite\Filament\Resources\Form\FormResource::class : null,
            $this->includeContact ? \Eii\WebSuite\Filament\Resources\FormSubmission\FormSubmissionResource::class : null,
            $this->includeSeo ? \Eii\WebSuite\Filament\Resources\SeoMetadata\SeoMetadataResource::class : null,
            $this->includeSeo ? \Eii\WebSuite\Filament\Resources\SeoRedirect\SeoRedirectResource::class : null,
        ]));
    }

    /**
     * @return array<class-string>
     */
    public function getPages(): array
    {
        if ($this->customPages !== null) {
            return $this->customPages;
        }

        if (! $this->includeSettings) {
            return [];
        }

        return [
            \Eii\WebSuite\Filament\Pages\Settings::class,
        ];
    }
}
