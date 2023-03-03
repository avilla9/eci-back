<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\ColorSchemeController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProductivityController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');
Route::get('color-scheme-switcher/{color_scheme}', [ColorSchemeController::class, 'switch'])->name('color-scheme-switcher');

Route::middleware('loggedin')->group(function () {
    Route::get('login', [AuthController::class, 'loginView'])->name('login.index');
    Route::post('login', [AuthController::class, 'login'])->name('login.check');
    Route::get('register', [AuthController::class, 'registerView'])->name('register.index');
    Route::post('register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/contraseña', [PageController::class, 'getEmail'])->name('contraseña.usuarios');
    Route::get('/nueva-contraseña/{id}', [UserController::class, 'newPassword'])->name('users.new.password');
});

Route::middleware('auth')->group(function () {
    // Route::get('/', [PageController::class, 'dashboardOverview1'])->name('dashboard-overview-1');
    Route::get('/', [PageController::class, 'userList'])->name('lista-de-usuarios');

    Route::get('/notifications', function () {
        return redirect()->away('https://console.firebase.google.com/project/app-eci/messaging');
    })->name('firebase-notification');

    Route::prefix('/file')->group(function () {
        Route::controller(PageController::class)->group(function () {
            Route::get('/up', 'filesUp')->name('file.up');
            Route::get('/list', 'filesList')->name('file.list');
        });

        Route::controller(FileController::class)->group(function () {
            Route::post('/upload', 'upload')->name('file.upload');
            Route::post('/delete', 'delete')->name('file.delete');
        });
    });

    Route::prefix('/usuarios')->group(function () {
        Route::controller(PageController::class)->group(function () {
            // Route::get('/lista', 'userList')->name('lista-de-usuarios');
            Route::get('/crear', 'userCreate')->name('crear-usuarios');
            Route::get('/subir', 'userUpload')->name('subir-usuarios');
            Route::get('/eliminar', 'deleteUserUpload')->name('eliminar-usuarios');
        });

        Route::controller(UserController::class)->group(function () {
            Route::post('/store', 'store')->name('user.store');
            Route::post('/users-import', 'fileImport')->name('file-import');
            Route::post('/users-delete', 'deleteImport')->name('file-delete');
            Route::put('/update', 'update')->name('user.update');
        });
    });

    Route::prefix('/roles')->group(function () {
        Route::controller(PageController::class)->group(function () {
            Route::get('/crear', 'roleCreate')->name('create-role');
        });

        Route::controller(RoleController::class)->group(function () {
            Route::get('/lista', 'index')->name('role-list');
            Route::post('/store', 'store')->name('role.store');
        });
    });

    Route::prefix('/campañas')->group(function () {
        Route::controller(PageController::class)->group(function () {
            Route::get('/crear', 'campaignCreate')->name('campaign-create');
            Route::get('/lista', 'campaignList')->name('campaign-list');
        });

        Route::controller(CampaignController::class)->group(function () {
            Route::post('/store', 'store')->name('campaign.store');
            Route::put('/update', 'update')->name('campaign.update');
            Route::post('/delete', 'delete')->name('campaign.delete');
        });
    });

    Route::prefix('/posts')->group(function () {
        Route::controller(ArticleController::class)->group(function () {
            Route::post('/delete', 'delete')->name('article.delete');
            Route::post('/access', 'access')->name('article.access');
        });
        Route::prefix('/stories')->group(function () {
            Route::controller(PageController::class)->group(function () {
                Route::get('/crear', 'storieCreate')->name('create-storie');
                Route::get('/lista', 'storieList')->name('stories-list');
            });

            Route::controller(ArticleController::class)->group(function () {
                Route::post('/create', 'storyCreate')->name('story.create');
            });
        });
        Route::prefix('/home')->group(function () {
            Route::controller(PageController::class)->group(function () {
                Route::get('/crear', 'homeCreate')->name('home-create');
                Route::get('/lista', 'homeList')->name('homes-list');
            });
            Route::controller(ArticleController::class)->group(function () {
                Route::post('/create', 'homeCreate')->name('home.create');
            });
        });
        Route::prefix('/campaign')->group(function () {
            Route::controller(PageController::class)->group(function () {
                Route::get('/crear', 'contentCampaignCreate')->name('content-campaign-create');
                Route::get('/lista', 'contentCampaignList')->name('content-campaign-list');
            });
            Route::controller(ArticleController::class)->group(function () {
                Route::post('/create', 'campaignCreate')->name('campaign.create');
            });
        });

        Route::prefix('/adoption')->group(function () {
            Route::controller(PageController::class)->group(function () {
                Route::get('/crear', 'contentadoptionCreate')->name('content-adoption-create');
                Route::get('/lista', 'contentadoptionList')->name('content-adoption-list');
                Route::get('/details/{id}', 'contentAdoptionDetails')->name('content.adoption.details');
            });
            Route::controller(ArticleController::class)->group(function () {
                Route::post('/create', 'adoptionCreate')->name('adoption.create');
            });
        });

        Route::prefix('/knowledge')->group(function () {
            Route::controller(PageController::class)->group(function () {
                Route::get('/crear', 'contentknowledgeCreate')->name('content-knowledge-create');
                Route::get('/lista', 'contentknowledgeList')->name('content-knowledge-list');
            });
            Route::controller(ArticleController::class)->group(function () {
                Route::post('/create', 'knowledgeCreate')->name('knowledge.create');
            });
        });

        Route::prefix('/reward')->group(function () {
            Route::controller(PageController::class)->group(function () {
                Route::get('/crear', 'contentrewardCreate')->name('content-reward-create');
                Route::get('/lista', 'contentrewardList')->name('content-reward-list');
                Route::get('details/{id}', 'contentRewardDetails')->name('content.reward.details');
            });
            Route::controller(ArticleController::class)->group(function () {
                Route::post('/create', 'rewardCreate')->name('reward.create');
            });
        });

        Route::prefix('/room')->group(function () {
            Route::controller(PageController::class)->group(function () {
                Route::get('/crear', 'contentroomCreate')->name('content-room-create');
                Route::get('/lista', 'contentroomList')->name('content-room-list');
                Route::get('/secciones', 'contentroomSections')->name('section-room-create');
                Route::get('details/{id}', 'contentRoomDetails')->name('content.room.details');
            });
            Route::controller(ArticleController::class)->group(function () {
                Route::post('/create', 'roomCreate')->name('room.create');
                Route::post('/section', 'roomSection')->name('room.section');
                Route::post('/creation', 'sectionCreate');
                
            });
        });

        Route::prefix('/access')->group(function () {
            Route::controller(PageController::class)->group(function () {
                Route::get('/crear', 'contentaccessCreate')->name('content-access-create');
                Route::get('/lista', 'contentaccessList')->name('content-access-list');
                Route::get('/details/{id}', 'contentAccessDetails')->name('content.access.details');
            });
            Route::controller(ArticleController::class)->group(function () {
                Route::post('/create', 'accessCreate')->name('access.create');
            });
        });
    });

    Route::prefix('/produccion')->group(function () {
        Route::controller(PageController::class)->group(function () {
            Route::get('/lista', 'productionData')->name('production-list');
        });

        Route::controller(ProductivityController::class)->group(function () {
            Route::get('/campaign', 'campaign')->name('production.campaign');
            Route::post('/create', 'create')->name('production.create');
            Route::post('/import', 'fileImport')->name('production.import');
            Route::post('/delete', 'delete')->name('production.delete');
        });
    });

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    // Route::get('/', [PageController::class, 'dashboardOverview1'])->name('dashboard-overview-1');
    Route::get('dashboard-overview-2-page', [PageController::class, 'dashboardOverview2'])->name('dashboard-overview-2');
    Route::get('dashboard-overview-3-page', [PageController::class, 'dashboardOverview3'])->name('dashboard-overview-3');
    Route::get('inbox-page', [PageController::class, 'inbox'])->name('inbox');
    Route::get('file-manager-page', [PageController::class, 'fileManager'])->name('file-manager');
    Route::get('point-of-sale-page', [PageController::class, 'pointOfSale'])->name('point-of-sale');
    Route::get('chat-page', [PageController::class, 'chat'])->name('chat');
    Route::get('post-page', [PageController::class, 'post'])->name('post');
    Route::get('calendar-page', [PageController::class, 'calendar'])->name('calendar');
    Route::get('crud-data-list-page', [PageController::class, 'crudDataList'])->name('crud-data-list');
    Route::get('crud-form-page', [PageController::class, 'crudForm'])->name('crud-form');
    Route::get('users-layout-1-page', [PageController::class, 'usersLayout1'])->name('users-layout-1');
    Route::get('users-layout-2-page', [PageController::class, 'usersLayout2'])->name('users-layout-2');
    Route::get('users-layout-3-page', [PageController::class, 'usersLayout3'])->name('users-layout-3');
    Route::get('profile-overview-1-page', [PageController::class, 'profileOverview1'])->name('profile-overview-1');
    Route::get('profile-overview-2-page', [PageController::class, 'profileOverview2'])->name('profile-overview-2');
    Route::get('profile-overview-3-page', [PageController::class, 'profileOverview3'])->name('profile-overview-3');
    Route::get('wizard-layout-1-page', [PageController::class, 'wizardLayout1'])->name('wizard-layout-1');
    Route::get('wizard-layout-2-page', [PageController::class, 'wizardLayout2'])->name('wizard-layout-2');
    Route::get('wizard-layout-3-page', [PageController::class, 'wizardLayout3'])->name('wizard-layout-3');
    Route::get('blog-layout-1-page', [PageController::class, 'blogLayout1'])->name('blog-layout-1');
    Route::get('blog-layout-2-page', [PageController::class, 'blogLayout2'])->name('blog-layout-2');
    Route::get('blog-layout-3-page', [PageController::class, 'blogLayout3'])->name('blog-layout-3');
    Route::get('pricing-layout-1-page', [PageController::class, 'pricingLayout1'])->name('pricing-layout-1');
    Route::get('pricing-layout-2-page', [PageController::class, 'pricingLayout2'])->name('pricing-layout-2');
    Route::get('invoice-layout-1-page', [PageController::class, 'invoiceLayout1'])->name('invoice-layout-1');
    Route::get('invoice-layout-2-page', [PageController::class, 'invoiceLayout2'])->name('invoice-layout-2');
    Route::get('faq-layout-1-page', [PageController::class, 'faqLayout1'])->name('faq-layout-1');
    Route::get('faq-layout-2-page', [PageController::class, 'faqLayout2'])->name('faq-layout-2');
    Route::get('faq-layout-3-page', [PageController::class, 'faqLayout3'])->name('faq-layout-3');
    Route::get('login-page', [PageController::class, 'login'])->name('login');
    Route::get('register-page', [PageController::class, 'register'])->name('register');
    Route::get('error-page-page', [PageController::class, 'errorPage'])->name('error-page');
    Route::get('update-profile-page', [PageController::class, 'updateProfile'])->name('update-profile');
    Route::get('change-password-page', [PageController::class, 'changePassword'])->name('change-password');
    Route::get('regular-table-page', [PageController::class, 'regularTable'])->name('regular-table');
    Route::get('tabulator-page', [PageController::class, 'tabulator'])->name('tabulator');
    Route::get('modal-page', [PageController::class, 'modal'])->name('modal');
    Route::get('slide-over-page', [PageController::class, 'slideOver'])->name('slide-over');
    Route::get('notification-page', [PageController::class, 'notification'])->name('notification');
    Route::get('accordion-page', [PageController::class, 'accordion'])->name('accordion');
    Route::get('button-page', [PageController::class, 'button'])->name('button');
    Route::get('alert-page', [PageController::class, 'alert'])->name('alert');
    Route::get('progress-bar-page', [PageController::class, 'progressBar'])->name('progress-bar');
    Route::get('tooltip-page', [PageController::class, 'tooltip'])->name('tooltip');
    Route::get('dropdown-page', [PageController::class, 'dropdown'])->name('dropdown');
    Route::get('typography-page', [PageController::class, 'typography'])->name('typography');
    Route::get('icon-page', [PageController::class, 'icon'])->name('icon');
    Route::get('loading-icon-page', [PageController::class, 'loadingIcon'])->name('loading-icon');
    Route::get('regular-form-page', [PageController::class, 'regularForm'])->name('regular-form');
    Route::get('datepicker-page', [PageController::class, 'datepicker'])->name('datepicker');
    Route::get('tom-select-page', [PageController::class, 'tomSelect'])->name('tom-select');
    Route::get('file-upload-page', [PageController::class, 'fileUpload'])->name('file-upload');
    Route::get('wysiwyg-editor-classic', [PageController::class, 'wysiwygEditorClassic'])->name('wysiwyg-editor-classic');
    Route::get('wysiwyg-editor-inline', [PageController::class, 'wysiwygEditorInline'])->name('wysiwyg-editor-inline');
    Route::get('wysiwyg-editor-balloon', [PageController::class, 'wysiwygEditorBalloon'])->name('wysiwyg-editor-balloon');
    Route::get('wysiwyg-editor-balloon-block', [PageController::class, 'wysiwygEditorBalloonBlock'])->name('wysiwyg-editor-balloon-block');
    Route::get('wysiwyg-editor-document', [PageController::class, 'wysiwygEditorDocument'])->name('wysiwyg-editor-document');
    Route::get('validation-page', [PageController::class, 'validation'])->name('validation');
    Route::get('chart-page', [PageController::class, 'chart'])->name('chart');
    Route::get('slider-page', [PageController::class, 'slider'])->name('slider');
    Route::get('image-zoom-page', [PageController::class, 'imageZoom'])->name('image-zoom');
});
