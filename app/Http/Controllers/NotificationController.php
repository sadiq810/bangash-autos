<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Webtoken;
use Yajra\DataTables\DataTables;

class NotificationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.notification.index');
    }//..... end index() .....//

    /**
     * @param int $limit
     * @param string $order
     * @return mixed
     * Get notifications list.
     */
    public function getNotifications($limit = 10, $order = 'desc')
    {
        return Notification::limit($limit)->orderBy('id', $order)->get();
    }//..... end of getNotifications() .....//

    /**
     * @return mixed
     * @throws \Exception
     * Notification list for DataTables.
     */
    public function notificationListForDataTables()
    {
        return DataTables::of(Notification::query())->make(true);
    }//..... end of notificationListForDataTables() .....//

    /**
     * @return array
     * Save user token for web push notifications.
     */
    public function saveToken()
    {
        Webtoken::firstOrCreate(request()->only('token'));
        return ['status' => true];
    }//..... end of saveToken() .....//

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadSendNotificationView()
    {
        return view('admin.notification.send_notifications');
    }//..... end of loadSendNotificationView() .....//

    /**
     * @return array
     * Send push notifications to subscribers.
     */
    public function sendPushNotification()
    {
        $tokens = Webtoken::pluck('token');

        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode(['data' => request()->only(['title', 'body', 'icon', 'click_action']),
                    "registration_ids" => $tokens]),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: key=AAAAtx_R8_c:APA91bGzf4xdHjgz5BNgYiy2R0_Sr02J95XlXNDHmnAK0UewJmM-FMJvQNNIwZnKqk4SI6lbUmGAnz8DrO01f4Jd7MRHQL76sRG1ITEB2d1y_-pDegNALDsqejsNmNkc1M9LeXRiU7ku"
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return ['status' => true, 'message' => 'Push notification send successfully.'];
        } catch (\Exception $exception) {
            return ['status' => false, 'message' => "Error occurred, while sending push notification"];
        }//..... end of try-catch() .....//
    }//..... end of sendPushNotification() .....//
}
