<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CmsPage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\MessageBag;

class SeedCmsPages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:migrate-pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing Blade views to static CMS Pages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pages = [
            // Home Routes
            '/' => ['view' => 'home.index', 'title' => 'Home'],
            '/members' => ['view' => 'home.members', 'title' => 'Members Directory'],
            '/events' => ['view' => 'home.events', 'title' => 'Upcoming Events'],
            '/gallery' => ['view' => 'home.gallery', 'title' => 'Photo Gallery'],
            '/donors' => ['view' => 'home.donors', 'title' => 'Our Donors'],
            '/sponsors' => ['view' => 'home.sponsors', 'title' => 'Sponsors'],
            '/notices' => ['view' => 'home.notices', 'title' => 'Notice Board'],
            
            // Businzo Routes
            '/about' => ['view' => 'businzo.pages.about', 'title' => 'About Us'],
            '/services' => ['view' => 'businzo.pages.services', 'title' => 'Services'],
            '/portfolio' => ['view' => 'businzo.pages.portfolio', 'title' => 'Portfolio'],
            '/portfolio/rcms' => ['view' => 'businzo.pages.portfolio-rcms', 'title' => 'Portfolio - RCMS'],
            '/contact' => ['view' => 'businzo.pages.contact', 'title' => 'Contact Us'],
            '/privacy' => ['view' => 'businzo.pages.privacy', 'title' => 'Privacy Policy'],
            '/terms' => ['view' => 'businzo.pages.terms', 'title' => 'Terms of Service'],
            '/careers' => ['view' => 'businzo.pages.careers', 'title' => 'Careers'],
        ];

        $this->info("Starting migration of " . count($pages) . " pages to CMS...");

        foreach ($pages as $slug => $data) {
            $this->line("Processing: {$slug} ({$data['view']})");
            
            $viewPath = resource_path('views/' . str_replace('.', '/', $data['view']) . '.blade.php');
            
            if (!File::exists($viewPath)) {
                $this->error("  -> View file not found: {$viewPath}");
                continue;
            }

            $rawContent = File::get($viewPath);

            // Extract content inside @section('content') ... @endsection
            preg_match('/@section\(\'content\'\)(.*?)@endsection/s', $rawContent, $matches);
            
            if (empty($matches[1])) {
                $this->warn("  -> No @section('content') found. Skipping.");
                continue;
            }

            $bladeContent = $matches[1];

            // Provide dummy data so Blade::render doesn't throw undefined variable errors
            // We just pass empty arrays/objects for the variables typically used in these views.
            $viewErrorBag = new ViewErrorBag();
            $viewErrorBag->put('default', new MessageBag());

            $dummyData = [
                'announcements' => [],
                'events' => [],
                'members' => new LengthAwarePaginator([], 0, 15),
                'galleries' => [],
                'donors' => [],
                'sponsors' => [],
                'activeOrg' => (object)['name' => 'Community'],
                'errors' => $viewErrorBag,
            ];

            try {
                $compiledHtml = Blade::render($bladeContent, $dummyData);
                
                // Save to DB
                CmsPage::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'title' => $data['title'],
                        'html' => $compiledHtml,
                        'is_published' => false // Keep it unpublished so it doesn't break production instantly
                    ]
                );
                $this->info("  -> Successfully migrated to CMS.");
            } catch (\Exception $e) {
                $this->error("  -> Error rendering blade: " . $e->getMessage());
            }
        }

        $this->info("Migration completed! You can now view these pages in the CMS dashboard.");
    }
}
