<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\NewsletterController;
use App\Http\Controllers\admin\TemplateController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\InstallerRecordsController;




Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/documents/{category}', [DocumentController::class, 'documents'])->name('documents');

Route::prefix('innstaller-records')->group(function () {
    Route::get('/company-documents', [InstallerRecordsController::class, 'companyDocuments'])->name('company-documents');
    Route::get('/company-document/{id?}', [InstallerRecordsController::class, 'showCompanyDocumentForm'])->name('company-document');
    Route::post('/company-document/{id?}', [InstallerRecordsController::class, 'createCompanyDocument'])->name('create-company-document');
    Route::delete('/company-document/{id}', [InstallerRecordsController::class, 'destroy'])->name('company-document.destroy');
    Route::post('/upload-company-document/{documentId}', [InstallerRecordsController::class, 'uploadCompanyDocument'])->name('upload-company-document');
    Route::get('/company-document/{documentId}/{fileId?}',[InstallerRecordsController::class, 'showCompanyDocumentForm'])->name('company-document.form');
    
    
    // delete a file
    Route::delete('/company-document-file/{documentId}/{fileId}',[InstallerRecordsController::class, 'destroyFile'])->name('delete-company-document-file');
    
    // download a file
    Route::get('/download-company-document/{documentId}/{fileId}', [InstallerRecordsController::class, 'downloadCompanyDocument'])->name('download-company-document');
    
    Route::get('/sub-contractors', [InstallerRecordsController::class, 'subcontractors'])->name('subcontractors');
    
    // Subcontractor create/edit form
    Route::get('/sub-contractor/{id?}', [InstallerRecordsController::class, 'showSubcontractorForm'])->name('subcontractor.form');
    
    // Store or update subcontractor
    Route::post('/sub-contractor/{id?}', [InstallerRecordsController::class, 'saveSubcontractor'])->name('subcontractors.store');
    
    // Delete subcontractor
    Route::delete('/sub-contractor/{id}', [InstallerRecordsController::class, 'destroySubcontractor'])->name('subcontractor.destroy');
    
    Route::post('/upload-subcontractor-document/{subcontractorId}', [InstallerRecordsController::class, 'uploadSubcontractorDocument'])->name('upload-subcontractor-document');
    
    Route::delete('/sub-contractor-document/{id}', [InstallerRecordsController::class, 'destroySubcontractorFile'])->name('subcontractor-document.destroy');
    Route::get('/download-sub-contractor-document/{documentId}/{fileId}', [InstallerRecordsController::class, 'downloadSubcontractorDocument'])->name('download-subcontractor-document');
    //p
    Route::get('/personal-skills', [InstallerRecordsController::class, 'personalSkills'])->name('personal-skills');
    Route::get('/personal-skill/{id?}', [InstallerRecordsController::class, 'showPersonalSkillsForm'])->name('personal-skills.form');
    Route::post('/personal-skills/{id?}', [InstallerRecordsController::class, 'savePersonalSkills'])->name('personal-skills.store');
    Route::delete('/personal-skills/{id}', [InstallerRecordsController::class, 'destroyPersonalSkills'])->name('personal-skills.destroy');
    Route::delete('/skills-course/{skillId}/{courseId}', [InstallerRecordsController::class, 'destroySkillsCourse'])->name('skills-course.destroy');
    Route::delete('/skills-competence/{skillId}/{competenceId}', [InstallerRecordsController::class, 'destroySkillsCompetence'])->name('skills-competence.destroy');
    // pe
    
    Route::get('/complaints-records', [InstallerRecordsController::class, 'complaintsRecords'])->name('complaints-records');
    Route::get('/complaints-record/{id?}', [InstallerRecordsController::class, 'showComplaintsRecordForm'])->name('complaints-record.form');
    Route::post('/complaints-record/{id?}', [InstallerRecordsController::class, 'complaintsRecordStore'])->name('complaints-record.store');
    Route::delete('/complaints-record/{id}', [InstallerRecordsController::class, 'complaintsRecordDestroy'])->name('complaints-record.destroy');

    Route::get('/suppliers', [InstallerRecordsController::class, 'suppliers'])->name('suppliers');
    Route::get('/supplier/{id?}', [InstallerRecordsController::class, 'showSupplierForm'])->name('supplier.form');
    Route::post('/supplier/{id?}', [InstallerRecordsController::class, 'saveSupplier'])->name('suppliers.store');
    Route::delete('/supplier/{id}', [InstallerRecordsController::class, 'destroySupplier'])->name('supplier.destroy');

    Route::get('/projects-folder', [InstallerRecordsController::class, 'projectsFolder'])->name('projects-folder');
    Route::get('/project-folder/{id?}', [InstallerRecordsController::class, 'showprojectsFolderForm'])->name('projects-folder.form');
    Route::post('/projects-folder/{id?}', [InstallerRecordsController::class, 'storeOrUpdate'])->name('projects-folder.save');
    Route::delete('/projects-folder/{id}', [InstallerRecordsController::class, 'destroyProject'])->name('projects-folder.destroy');
});



Route::get('admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/download-file',[TemplateController::class, 'downloadFile'])->name('download-file');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    // This route is only accessible by authenticated organizations with the 'admin' role
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/organizations', [UserController::class, 'index']);
    Route::get('/organizations/list', [UserController::class, 'organizationsList'])->name('organizations.list');
    Route::post('/organizations/store', [UserController::class, 'store'])->name('organizations.store');   
    
    Route::get('/newsletters', [NewsletterController::class, 'index']);
    Route::get('/newsletters/list', [NewsletterController::class, 'newslettersList'])->name('admin.newsletters.list');
    Route::post('/newsletters-create', [NewsletterController::class, 'create'])->name('admin.newsletter.create');
    
    Route::get('/templates', [TemplateController::class, 'index']);
    Route::get('/templates/list', [TemplateController::class, 'templatesList'])->name('templates.list');
    Route::get('/template/{id?}', [TemplateController::class, 'showTemplateForm'])->name('template');
    Route::post('/template-create/{id?}', [TemplateController::class, 'create'])->name('template.create');
});