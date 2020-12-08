<?php
namespace App\Services;

use App\Http\Requests\PostStoreRequest;
use App\Repositories\PostRepositoryInterface;
use App\Services\Snippets\AccordionService;
use App\Services\Snippets\GalleryMasonryService;

class PostService {
    private $postRepository;
    private $accordionService;
    private $galleryService;
    private $glossaryService;

    public function __construct(
        PostRepositoryInterface $postRepository,
        AccordionService $accordionService,
        GalleryMasonryService $galleryService,
        GlossaryService $glossaryService
    ) {
        $this->postRepository = $postRepository;
        $this->accordionService = $accordionService;
        $this->galleryService = $galleryService;
        $this->glossaryService = $glossaryService;
    }

    public function getPostBody($post){
        $postBody = $post->body;

        $postBody = $this->accordionService->snippetsToHTML($postBody);
        $postBody = $this->galleryService->snippetsToHTML($postBody);
        $postBody = $this->glossaryService->markGlossaryTerms($postBody);

        return $postBody;
    }

    /**
     * Create an alert
     *
     * @param \App\Http\Requests\PostStoreRequest $data
     *
     * @return \App\Models\Post
     */
    public function createAlert(PostStoreRequest $data)
    {
        $alert = $this->alertRepository->store($data);

        $alert->setStatus('pending');

        $this->storeImages($alert, $data);

        return $alert;
    }

    /**
     * Update the alert
     *
     * @param \App\Http\Requests\PostStoreRequest $data
     * @param int $postId
     *
     * @return \App\Models\Post
     */
    public function updateAlert(PostStoreRequest $data, int $postId)
    {
        if (isset($data['save'])) {
            $alert = $this->saveAlert($data, $postId);
        }

        if (isset($data['approve_and_send'])) {
            $alert = $this->approveAndSendAlert($data, $postId);
        }

        $this->storeImages($alert, $data);

        return $alert;
    }

    /**
     * Return the alert from the database
     *
     * @param $postId
     *
     * @return \App\Alert
     */
    public function getById(int $postId)
    {
        return $this->alertRepository->getById($postId);
    }

    /**
     * Get all the alerts.
     *
     * @return iterable
     */
    public function getAlerts()
    {
        return $this->alertRepository->getAll(20);
    }

    /**
     * Delete the alert from the database
     *
     * @param int $postId
     */
    public function deleteAlert(int $postId): void
    {
        $this->alertRepository->delete($postId);
    }

    /**
     * Approve ans send the alert
     *
     *  We update the approver since any admin can approve the alert,
     *  not just the one selected as approver. So in this field there is the
     *  user that effectively approved the alert.
     *  That gets displayed as approver on the right bar of the alert edit view.
     *
     * @param \App\Http\Requests\AlertStoreRequest $data
     * @param int $postId
     *
     * @return \App\Alert
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function approveAndSendAlert(AlertStoreRequest $data, int $postId): Alert
    {
        $alert = $this->alertRepository->getById($postId);

        // Set the approver as the final person that approved the alert
        $data['approver'] = Auth::id();

        $data['sent_on'] = date("Y-m-d H:i:s");

        $alert = $this->alertRepository->update($data, $postId);

        $alert->setStatus('approved', Auth::id());

        if(($data['send_as_sms'] == 'on') && (!$alert->hasEverHadStatus('sms_sent'))){

            //$members = $this->memberService->getMembers();
            $members = $this->memberService->getMembersByAlertRegion($alert->region_id);

            $photos = $alert->getMedia('alert');
            if($photos->isEmpty()){
                SendSms::dispatch($alert, $members)->onQueue('default');
            }
            else{
                SendMms::dispatch($alert, $members)->onQueue('default');
            }

            $alert->setStatus('sms_sent', Auth::id());
        }

        if(($data['send_as_email'] == 'on') && (!$alert->hasEverHadStatus('mail_sent'))){

            $members = $this->memberService->getMembersByAlertRegion($alert->region_id);

            SendMail::dispatch($alert, $members)->onQueue('default');

            $alert->setStatus('mail_sent', Auth::id());
        }

        return $alert;
    }

    /**
     *  Update the alert once the save button is clicked in the alert edit view
     *
     * @param \App\Http\Requests\AlertStoreRequest $data
     * @param int $postId
     *
     * @return \App\Alert
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function saveAlert(AlertStoreRequest $data, int $postId): Alert
    {
        $alert = $this->alertRepository->getById($postId);

        if($alert->approver()->first()->id != $data['approver']){
            $approver = $this->userRepository->getById($data['approver']);

            // Send to the approver a mail notification
            $approver->notify(new AdminChosenAsApproverNotification($approver, $alert));
        }

        $alert = $this->alertRepository->update($data, $postId);

        return $alert;
    }

    /**
     * Get all the admin that can approve an alert .
     *
     * @return iterable
     */
    public function getAllAlertApprovers()
    {
        return User::role(['Super Admin', 'Admin'])->get();
    }

    /**
     * Get the total pending alerts number.
     *
     * @return iterable
     */
    public function getPendingAlertsNumber()
    {
        return Alert::currentStatus('pending')->count();
    }

    /**
     * Get the number of alerts sent in the last 30 days.
     *
     * @return iterable
     */
    public function getNumberAlertsSentLastThirtyDays()
    {
        return Alert::whereDate('sent_on', '>', date('Y-m-d', strtotime('-30 days')))->count();
    }

    /**
     * Get the number of the pending alerts assigned to the user.
     *
     * @return iterable
     */
    public function getAssignedPendingAlertsNumber()
    {
        return Auth::user()->alertsToApprove->count();
    }

    /**
     * Store the uploaded photos in the Spatie Media Library
     *
     * @param \App\Alert $alert
     * @param \App\Http\Requests\AlertStoreRequest $data
     *
     * @return void
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    private function storeImages(Alert $alert, AlertStoreRequest $data):void {
        if($data->file('photos')) {
            foreach ($data->file('photos') as $photo) {
                if ($photo->isValid()) {
                    $alert->addMedia($photo)->toMediaCollection('alert');
                }
            }
        }
    }

    /**
     * Return an array with the thumb images ulrs
     *
     * @param int $postId
     *
     * @return array
     */
    public function getThumbsUrls(int $postId): array{
        $thumbUrls = [];

        $alert = $this->getById($postId);
        foreach($alert->getMedia('alert') as $photo){
            $thumbUrls[] = $photo->getUrl('thumb');
        }

        return $thumbUrls;
    }


    /**
     * Return the alert status history
     *
     * @param int $postId
     *
     * @return array
     */
    public function getAlertStatusHistory(int $postId): array{

        $alert = $this->getById($postId);

        $statusHistory = [];

        foreach($alert->statuses->sortByDesc('created_at') as $key => $status){

            $statusHistory[$key]['date'] = $status->created_at->format('d/m/Y');
            $statusHistory[$key]['time'] = $status->created_at->format('H:i');

            switch ($status) {
                case 'pending':
                    $statusHistory[$key]['label'] = 'added to website';
                    $statusHistory[$key]['name'] = $alert->author->profile->name;
                    $statusHistory[$key]['surname'] = $alert->author->profile->surname;
                    break;
                case 'approved':
                    $statusHistory[$key]['label'] = 'approved';
                    $statusHistory[$key]['name'] = $this->adminService->getById($status->reason)->profile->name;
                    $statusHistory[$key]['surname'] = $this->adminService->getById($status->reason)->profile->surname;
                    break;
                case 'disapproved':
                    $statusHistory[$key]['label'] = 'disapproved';
                    $statusHistory[$key]['name'] = $this->adminService->getById($status->reason)->profile->name;
                    $statusHistory[$key]['surname'] = $this->adminService->getById($status->reason)->profile->surname;
                    break;
                case 'updated':
                    $statusHistory[$key]['label'] = 'updated';
                    $statusHistory[$key]['name'] = $this->adminService->getById($status->reason)->profile->name;
                    $statusHistory[$key]['surname'] = $this->adminService->getById($status->reason)->profile->surname;
                    break;
                case 'sms_sent':
                    $statusHistory[$key]['label'] = 'sent via SMS';
                    $statusHistory[$key]['name'] = $this->adminService->getById($status->reason)->profile->name;
                    $statusHistory[$key]['surname'] = $this->adminService->getById($status->reason)->profile->surname;
                    break;
                case 'mail_sent':
                    $statusHistory[$key]['label'] = 'sent via Email';
                    $statusHistory[$key]['name'] = $this->adminService->getById($status->reason)->profile->name;
                    $statusHistory[$key]['surname'] = $this->adminService->getById($status->reason)->profile->surname;
                    break;
            }
        }
        return $statusHistory;
    }
}