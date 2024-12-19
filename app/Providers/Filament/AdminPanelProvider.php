<?php

namespace App\Providers\Filament;

use App\Filament\Pages\AccessibilitySettings;
use App\Filament\Pages\KanbanBoard;
use Awcodes\Curator\CuratorPlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;

use Filament\Widgets;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Hasnayeen\Themes\Http\Middleware\SetTheme;

use Hasnayeen\Themes\ThemesPlugin;
use IbrahimBougaoua\FilaSortable\FilaSortablePlugin;

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

use Illuminate\Cookie\Middleware\EncryptCookies;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

use Illuminate\Routing\Middleware\SubstituteBindings;

use Illuminate\Session\Middleware\AuthenticateSession;

use Illuminate\Session\Middleware\StartSession;

use Illuminate\View\Middleware\ShareErrorsFromSession;

use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;


use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Joaopaulolndev\FilamentGeneralSettings\FilamentGeneralSettingsPlugin;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;
use ShuvroRoy\FilamentSpatieLaravelHealth\FilamentSpatieLaravelHealthPlugin;
use TomatoPHP\FilamentInvoices\FilamentInvoicesPlugin;
use Z3d0X\FilamentFabricator\Enums\BlockPickerStyle;
use Z3d0X\FilamentFabricator\FilamentFabricatorPlugin;










class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id("admin")
            ->path("admin")
            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification()

            ->brandLogo(asset('storage/assets/site_logo.png'))

            ->databaseNotifications()

            ->colors([
                "primary" => Color::Orange,
            ])
            ->font('Parkinsans')
            ->sidebarWidth('16rem')
        
            ->discoverResources(
                in: app_path("Filament/Resources"),
                for: "App\\Filament\\Resources"
            )
            ->discoverPages(
                in: app_path("Filament/Pages"),
                for: "App\\Filament\\Pages"
            )
            ->discoverClusters(in: app_path('Filament/Clusters'),
             for: 'App\\Filament\\Clusters')

            ->pages([Pages\Dashboard::class])
            ->discoverWidgets(
                in: app_path("Filament/Widgets"),
                for: "App\\Filament\\Widgets"
            )
            ->widgets([
                Widgets\AccountWidget::class,
//                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class,
            ])
            ->viteTheme("resources/css/filament/admin/theme.css")



            ->pages([
                
                KanbanBoard::class,
                

            ])

            ->navigationGroups([
                // Define groups in the order you want them to appear
                'Articles and Media',
                'Inquiries & Customers',
                'Project Manager',
                'Our Work',
                'Payments',
                'Settings',
            ])
               ->sidebarCollapsibleOnDesktop()




            ->plugins([

                FilaSortablePlugin::make(),

                FilamentGeneralSettingsPlugin::make()
->canAccess(fn() => auth()->user()->id === 1)
->setSort(3)
->setIcon("heroicon-o-cog")
->setNavigationGroup("Settings")
->setTitle("General Settings")
->setNavigationLabel("General Settings"),





                FilamentFabricatorPlugin::make()
                ->blockPickerStyle(BlockPickerStyle::Modal),


                \TomatoPHP\FilamentInvoices\FilamentInvoicesPlugin::make(),

                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),



                \Hasnayeen\Themes\ThemesPlugin::make(),

                FilamentSpatieLaravelBackupPlugin::make(),

                \Awcodes\Curator\CuratorPlugin::make(),

                FilamentSpatieLaravelHealthPlugin::make(),





                FilamentEditProfilePlugin::make()
                    ->slug("my-profile")
                    ->setTitle("My Profile")
                    ->setNavigationLabel("My Profile")
                    ->setNavigationGroup("Manage Users")
                    ->setIcon("heroicon-o-user-circle")
                    ->canAccess(fn() => auth()->user()->id === 1)
                    ->shouldShowDeleteAccountForm(true)
                    ->shouldShowSanctumTokens()
                    ->shouldShowBrowserSessionsForm()
                    ->shouldShowAvatarForm(),


            ])

 

            ->userMenuItems([
                "profile" => MenuItem::make()
                    ->label(fn() => auth()->user()->name)
                    ->url(fn(): string => EditProfilePage::getUrl())
                    ->icon("heroicon-m-user-circle"),


                        'view-website' => MenuItem::make()
                            ->label('View Website')
                            ->url('/')  // or route('home') if you have a named route
                            ->icon('heroicon-o-home')  // optional: adds an icon
                            ->openUrlInNewTab()  // optional: opens in new tab


                //If you are using tenancy need to check with the visible method where ->company() is the relation between the user and tenancy model as you called
                //  ->visible(function (): bool {
                // return auth()->user()->company()->exists();  }),
            ])

            ->authMiddleware([Authenticate::class]);


    }
}