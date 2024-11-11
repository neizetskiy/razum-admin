<?php
require ('../connect/connect.php');

// Проверяем, существует ли идентификатор урока
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $lessonId = $_GET['id'];

    // Получаем данные урока из базы данных
    $lesson = $database->query("SELECT * FROM `lessons` WHERE `id` = " . $lessonId)->fetch(2);

    if ($lesson) {
        // Получаем данные из формы
        $about = isset($_POST['about']) ? htmlspecialchars(trim($_POST['about'])) : $lesson['about'];
        $dateFrom = isset($_POST['dateFrom']) ? htmlspecialchars(trim($_POST['dateFrom'])) : $lesson['dateFrom'];
        $dateTo = isset($_POST['dateTo']) ? htmlspecialchars(trim($_POST['dateTo'])) : $lesson['dateTo'];

        $api_key = '6d8c234a-26c7-4bf2-984b-1005040cfd38';

        if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
            $video_file_path = $_FILES['video']['tmp_name'];

            $url = 'https://uploader.kinescope.io/video';
            $headers = [
                'X-Video-Title: ' . $_FILES['video']['name'],
                'X-Video-Description: ' . $about,
                'X-File-Name: ' . $_FILES['video']['name'],
                'Authorization: Bearer ' . $api_key
            ];


            $file_handle = fopen($video_file_path, 'rb');


            $curl = curl_init($url);


            curl_setopt_array($curl, [
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POSTFIELDS => stream_get_contents($file_handle), // Отправляем содержимое файла как тело запроса
                CURLOPT_RETURNTRANSFER => true
            ]);


            $response = curl_exec($curl);


            $log_file = 'kinescope_api.log';
            file_put_contents($log_file, "Headers: " . print_r($headers, true) . "\n", FILE_APPEND);
            file_put_contents($log_file, "Response: " . $response . "\n", FILE_APPEND);


            if (curl_errno($curl)) {
                echo 'Ошибка cURL: ' . curl_error($curl);
            } else {
                $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if ($http_code == 200) {
                    $response_data = json_decode($response, true);
                    if (isset($response_data['data']['play_link'])) {
                        $play_link = $response_data['data']['play_link'];
                        // Обновляем данные урока в базе данных
                        $sql = "UPDATE lessons SET about = :about, dateFrom = :dateFrom, dateTo = :dateTo, video = :video WHERE id = :id";
                        $stmt = $database->prepare($sql);
                        $stmt->execute([
                            'about' => $about,
                            'dateFrom' => $dateFrom,
                            'dateTo' => $dateTo,
                            'video' => $play_link,
                            'id' => $lessonId
                        ]);
                    } else {
                        echo 'Ошибка: play_link не найден в ответе API';
                    }
                } else {
                    echo 'Ошибка HTTP: ' . $http_code . ' ' . $response;
                }
            }


            fclose($file_handle);
            curl_close($curl);
            header("Location: /?page=updateLesson&id=" . urlencode($lessonId));
        } else {
            $sql = "UPDATE lessons SET about = :about, dateFrom = :dateFrom, dateTo = :dateTo WHERE id = :id";
            $stmt = $database->prepare($sql);
            $stmt->execute([
                'about' => $about,
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
                'id' => $lessonId
            ]);

            header("Location: /?page=updateLesson&id=" . urlencode($lessonId));
        }
    } else {
        echo 'Урок не найден';
    }
} else {
    echo 'Идентификатор урока не предоставлен';
}
?>



