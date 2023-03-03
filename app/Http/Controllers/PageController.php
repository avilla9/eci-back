<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Campaign;
use App\Models\Delegation;
use App\Models\File;
use App\Models\Group;
use App\Models\Page;
use App\Models\Quartile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PageController extends Controller {

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userList() {
        $users = User::all();
        $roles = Role::all();
        $groups = Group::all();
        $quartiles = Quartile::all();
        $delegations = Delegation::all();
        return view('pages/users/list', compact([
            'users', 'roles', 'groups', 'quartiles', 'delegations'
        ]));
    }

    public function productionData() {
        $users = User::select(
            'users.id as id',
            'users.dni as dni',
            'users.name as name',
        )
            ->join(
                'roles',
                'users.role_id',
                '=',
                'roles.id'
            )
            ->join(
                'quartiles',
                'quartiles.id',
                '=',
                'users.quartile_id'
            )
            ->join(
                'groups',
                'groups.id',
                '=',
                'users.group_id'
            )
            ->join(
                'delegations',
                'delegations.code',
                '=',
                'users.delegation_code'
            )
            ->where('users.active', 1)
            ->orderBy('name', 'desc')
            ->get();

        $campaigns = DB::table('campaigns')
            ->select(
                'campaigns.id as id',
                'campaigns.title as title',
                'campaigns.description as description',
                'campaigns.created_at as created_at',
                'pages.id as page_id',
                'pages.title as page_title',
            )
            ->join('pages', 'pages.id', '=', 'campaigns.page_id')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pages/production/list', compact(['campaigns', 'users']));
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userCreate() {
        $roles = Role::all();
        $groups = Group::all();
        $quartiles = Quartile::all();
        $delegations = Delegation::all();
        return view('pages/users/create', compact([
            'roles', 'groups', 'quartiles', 'delegations',
        ]));
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function roleCreate() {
        return view('pages/roles/create', []);
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userUpload() {
        return view('pages/users/upload', []);
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteUserUpload() {
        return view('pages/users/upload-delete', [
            // Specify the base layout.
            // Eg: 'side-menu', 'simple-menu', 'top-menu', 'login'
            // The default value is 'side-menu'

            // 'layout' => 'side-menu'
        ]);
    }

    /* public function storieCreate() {
        $data = contentParameters();
        return view('pages/stories/create', $data);
    }

    public function storieList() {
        return view('pages/stories/list');
    } */

    public function storieCreate() {
        $data = contentParameters();
        return view('pages/content/stories/create', $data);
    }

    public function contentStoryDetails($id) {
        $article = DB::table('articles')->where('id', $id)->first();
        $data = contentParameters();
        $data['article'] = $article;
        return view('pages/content/stories/update', $data);
    }

    public function storieList() {
        $stories = DB::table('articles')
            ->select('articles.*', 'files.media_path')
            ->join('files', 'files.id', '=', 'articles.file_id')
            ->where('articles.post_type', 'story')
            ->whereRaw('DATEDIFF(CURDATE(), articles.created_at) <= 1')
            ->orderBy('articles.created_at', 'desc')
            ->orderBy('articles.id', 'desc')
            ->get();

        return view('pages/content/stories/list', [
            'articles'  => $stories,
        ]);
    }

    public function home() {
        return view('pages/users/list');
    }

    public function homeCreate() {
        $data = contentParameters();
        $sections = sectionParameters('Home');
        $data['sections'] = $sections;
        return view('pages/content/home/create', $data);
    }

    public function homeList() {
        return view('pages/content/home/list', [
            'articles'  => articlesByPage('Home')
        ]);
    }

    public function contentCampaignCreate() {
        $data = contentParameters();
        $sections = sectionParameters('Campaña');
        $data['sections'] = $sections;
        $data['campaigns'] = DB::table('campaigns')
            ->select(
                'campaigns.id as id',
                'campaigns.title as title',
                'campaigns.description as description',
                'campaigns.created_at as created_at',
                'pages.id as page_id',
                'pages.title as page_title',
            )
            ->join('pages', 'pages.id', '=', 'campaigns.page_id')
            ->where('pages.title', 'Campaña')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pages/content/campaign/create', $data);
    }

    public function contentCampaignList() {
        return view('pages/content/campaign/list', [
            'articles'  => articlesByPage('Campaña')
        ]);
    }

    public function contentAdoptionCreate() {
        $data = contentParameters();
        $sections = sectionParameters('Adopción');
        $data['sections'] = $sections;
        $data['campaigns'] = DB::table('campaigns')
            ->select(
                'campaigns.id as id',
                'campaigns.title as title',
                'campaigns.description as description',
                'campaigns.created_at as created_at',
                'pages.id as page_id',
                'pages.title as page_title',
            )
            ->join('pages', 'pages.id', '=', 'campaigns.page_id')
            ->where('pages.title', 'Adopción')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pages/content/adoption/create', $data);
    }

    public function contentAdoptionDetails($id) {
        $article = DB::table('articles')->where('id', $id)->first();
        $data = contentParameters();
        $sections = sectionParameters('Adopción');
        $data['sections'] = $sections;
        $data['campaigns'] = DB::table('campaigns')
            ->select(
                'campaigns.id as id',
                'campaigns.title as title',
                'campaigns.description as description',
                'campaigns.created_at as created_at',
                'pages.id as page_id',
                'pages.title as page_title',
            )
            ->join('pages', 'pages.id', '=', 'campaigns.page_id')
            ->where('pages.title', 'Adopción')
            ->orderBy('created_at', 'desc')
            ->get();
        $data['article'] = $article;
        return view('pages/content/adoption/update', $data);
    }

    public function contentAdoptionList() {
        return view('pages/content/adoption/list', [
            'articles'  => articlesByPage('Adopción')
        ]);
    }

    public function campaignCreate() {
        $pages = DB::table('pages')
            ->where('title', 'Campaña')
            ->orWhere('title', 'Adopción')
            ->get();

        return view('pages/campaigns/create', compact(['pages']));
    }
    public function campaignList() {
        $campaigns = DB::table('campaigns')
            ->select('campaigns.id as id', 'campaigns.title as title', 'campaigns.description as description', 'campaigns.created_at as created_at', 'pages.id as page_id', 'pages.title as page_title')
            ->join('pages', 'pages.id', '=', 'campaigns.page_id')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pages/campaigns/list', compact(['campaigns']));
    }

    public function contentknowledgeCreate() {
        $data = contentParameters();
        $sections = sectionParameters('Conocimiento');
        $data['sections'] = $sections;
        return view('pages/content/knowledge/create', $data);
    }

    public function contentKnowledgeDetails($id) {
        $article = DB::table('articles')->where('id', $id)->first();
        $data = contentParameters();
        $sections = sectionParameters('Conocimiento');
        $data['sections'] = $sections;
        $data['article'] = $article;
        return view('pages/content/knowledge/update', $data);
    }

    function contentknowledgeList() {
        return view('pages/content/knowledge/list', [
            'articles'  => articlesByPage('Conocimiento')
        ]);
    }

    public function contentrewardCreate() {
        $data = contentParameters();
        $sections = sectionParameters('Recompensas');
        $data['sections'] = $sections;
        return view('pages/content/reward/create', $data);
    }

    function contentrewardList() {
        return view('pages/content/reward/list', [
            'articles'  => articlesByPage('Recompensas')
        ]);
    }

    public function contentRewardDetails($id) {
        $article = DB::table('articles')->where('id', $id)->first();
        $data = contentParameters();
        $sections = sectionParameters('Recompensas');
        $data['sections'] = $sections;
        $data['article'] = $article;
        return view('pages/content/reward/update', $data);
    }

    public function contentroomCreate() {
        $data = contentParameters();
        $sections = sectionParameters('Salas');
        $data['sections'] = $sections;
        return view('pages/content/room/create', $data);
    }

    public function contentRoomDetails($id) {
        $article = Article::where('id', $id)->first();
        $data = contentParameters();
        $sections = sectionParameters('Salas');
        $data['sections'] = $sections;
        $data['article'] = $article;
        return view('pages/content/room/update', $data);
    }

    function contentroomList() {
        return view('pages/content/room/list', [
            'articles'  => articlesByPage('Salas')
        ]);
    }

    function contentroomSections() {
        $groups = Group::all();
        $quartiles = Quartile::all();
        $delegations = Delegation::all();
        $roles = Role::all();
        $users = User::all();

        $sections = DB::table('pages')
            ->join('sections', 'sections.page_id', '=', 'pages.id')
            ->where('pages.title', 'Salas')
            ->get();
        $articles = DB::table('pages')
            ->select('sections.*', 'files.media_path as img')
            ->join('sections', 'sections.page_id', '=', 'pages.id')
            ->leftJoin('files', 'files.id', '=', 'sections.file_id')
            ->where('pages.title', 'Salas')
            ->get();
            
        $files = File::where('media_type', 'like', '%image%')->latest()->get();
        $filters = [];
            count($groups) > 0 ? $filters['groups'] = [
                'name' => 'Grupos',
                'data' => $groups
            ] : true;
            count($quartiles) > 0 ? $filters['quartiles'] = [
                'name' => 'Cuartiles',
                'data' => $quartiles
            ] : true;
            count($delegations) > 0 ? $filters['delegations'] = [
                'name' => 'Delegaciones',
                'data' => $delegations
            ] : true;
            count($roles) > 0 ? $filters['roles'] = [
                'name' => 'Codigo de Rol',
                'data' => $roles
            ] : true;
            count($users) > 0 ? $filters['users'] = [
                'name' => 'Usuarios',
                'data' => $users
            ] : true;

        return view('pages/content/room/sections', [
            'sections' => $sections,
            'articles'  => $articles,
            'files' => $files,
            'filters' => $filters

        ]);
    }

    public function contentaccessCreate() {
        $data = contentParameters();
        $sections = sectionParameters('Accesos');
        $data['sections'] = $sections;
        return view('pages/content/access/create', $data);
    }

    function contentaccessList() {
        return view('pages/content/access/list', [
            'articles'  => articlesByPage('Accesos')
        ]);
    }

    public function contentAccessDetails($id) {
        $article = DB::table('articles')->where('id', $id)->first();
        $data = contentParameters();
        $sections = sectionParameters('Accesos');
        $data['sections'] = $sections;
        $data['article'] = $article;
        return view('pages/content/access/update', $data);
    }

    public function filesList() {
        $files = File::all();
        $files = File::orderBy('updated_at', 'desc')->get();
        // File::where('media_type', 'like', '%pdf%')->get();

        return view('pages/files/list', [
            'files' => $files
        ]);
    }

    public function filesUp() {
        return view('pages/files/upload');
    }

    /* GENERIC COMPONENT BELOW */

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dashboardOverview1() {
        return view('pages/dashboard-overview-1', [
            // Specify the base layout.
            // Eg: 'side-menu', 'simple-menu', 'top-menu', 'login'
            // The default value is 'side-menu'

            // 'layout' => 'side-menu'
        ]);
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dashboardOverview2() {
        return view('pages/dashboard-overview-2');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dashboardOverview3() {
        return view('pages/dashboard-overview-3');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function inbox() {
        return view('pages/inbox');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fileManager() {
        return view('pages/file-manager');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pointOfSale() {
        return view('pages/point-of-sale');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function chat() {
        return view('pages/chat');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post() {
        return view('pages/post');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function calendar() {
        return view('pages/calendar');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function crudDataList() {
        return view('pages/crud-data-list');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function crudForm() {
        return view('pages/crud-form');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function usersLayout1() {
        return view('pages/users-layout-1');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function usersLayout2() {
        return view('pages/users-layout-2');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function usersLayout3() {
        return view('pages/users-layout-3');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profileOverview1() {
        return view('pages/profile-overview-1');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profileOverview2() {
        return view('pages/profile-overview-2');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profileOverview3() {
        return view('pages/profile-overview-3');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function wizardLayout1() {
        return view('pages/wizard-layout-1');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function wizardLayout2() {
        return view('pages/wizard-layout-2');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function wizardLayout3() {
        return view('pages/wizard-layout-3');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function blogLayout1() {
        return view('pages/blog-layout-1');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function blogLayout2() {
        return view('pages/blog-layout-2');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function blogLayout3() {
        return view('pages/blog-layout-3');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pricingLayout1() {
        return view('pages/pricing-layout-1');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pricingLayout2() {
        return view('pages/pricing-layout-2');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function invoiceLayout1() {
        return view('pages/invoice-layout-1');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function invoiceLayout2() {
        return view('pages/invoice-layout-2');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function faqLayout1() {
        return view('pages/faq-layout-1');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function faqLayout2() {
        return view('pages/faq-layout-2');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function faqLayout3() {
        return view('pages/faq-layout-3');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login() {
        return view('pages/login');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register() {
        return view('pages/register');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function errorPage() {
        return view('pages/error-page');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile() {
        return view('pages/update-profile');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword() {
        return view('pages/change-password');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function regularTable() {
        return view('pages/regular-table');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tabulator() {
        return view('pages/tabulator');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function modal() {
        return view('pages/modal');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function slideOver() {
        return view('pages/slide-over');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function notification() {
        return view('pages/notification');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accordion() {
        return view('pages/accordion');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function button() {
        return view('pages/button');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function alert() {
        return view('pages/alert');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function progressBar() {
        return view('pages/progress-bar');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tooltip() {
        return view('pages/tooltip');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dropdown() {
        return view('pages/dropdown');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function typography() {
        return view('pages/typography');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function icon() {
        return view('pages/icon');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loadingIcon() {
        return view('pages/loading-icon');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function regularForm() {
        return view('pages/regular-form');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function datepicker() {
        return view('pages/datepicker');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tomSelect() {
        return view('pages/tom-select');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fileUpload() {
        return view('pages/file-upload');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function wysiwygEditorClassic() {
        return view('pages/wysiwyg-editor-classic');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function wysiwygEditorInline() {
        return view('pages/wysiwyg-editor-inline');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function wysiwygEditorBalloon() {
        return view('pages/wysiwyg-editor-balloon');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function wysiwygEditorBalloonBlock() {
        return view('pages/wysiwyg-editor-balloon-block');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function wysiwygEditorDocument() {
        return view('pages/wysiwyg-editor-document');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validation() {
        return view('pages/validation');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function chart() {
        return view('pages/chart');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function slider() {
        return view('pages/slider');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function imageZoom() {
        return view('pages/image-zoom');
    }

    public function getEmail() {
        return view('pages.users.get_email', ['layout' => 'login']);
    }
}

function contentParameters() {
    $groups = Group::all();
    $quartiles = Quartile::all();
    $delegations = Delegation::all();
    $roles = Role::all();
    $users = User::all();
    $files = File::all();
    $files = File::orderBy('updated_at', 'desc')->get();
    // $files = File::where('media_type', 'like', '%image%')->latest()->get();

    $filters = [];
    count($groups) > 0 ? $filters['groups'] = [
        'name' => 'Grupos',
        'data' => $groups
    ] : true;
    count($quartiles) > 0 ? $filters['quartiles'] = [
        'name' => 'Cuartiles',
        'data' => $quartiles
    ] : true;
    count($delegations) > 0 ? $filters['delegations'] = [
        'name' => 'Delegaciones',
        'data' => $delegations
    ] : true;
    count($roles) > 0 ? $filters['roles'] = [
        'name' => 'Codigo de Rol',
        'data' => $roles
    ] : true;
    count($users) > 0 ? $filters['users'] = [
        'name' => 'Usuarios',
        'data' => $users
    ] : true;

    return [
        'filters' => $filters,
        'files' => $files,
    ];
}

function sectionParameters($pageName) {
    return DB::table('pages')
        ->select('sections.*')
        ->join('sections', 'sections.page_id', '=', 'pages.id')
        ->where('pages.title', $pageName)
        ->get();
}

function articlesByPage($pageName) {
    return DB::table('articles')
        ->select('articles.*', 'sections.title as section_title')
        ->join('sections', 'sections.id', '=', 'articles.section_id')
        ->join('pages', 'pages.id', '=', 'sections.page_id')
        ->where('pages.title', $pageName)
        ->orderBy('sections.title', 'asc')
        ->orderBy('articles.id', 'desc')
        ->get();
}