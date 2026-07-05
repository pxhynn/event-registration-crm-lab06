<?php
class Database
{
    public static function connect(array $config): PDO
    {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $config['host'],
            $config['database'],
            $config['charset']
        );

        try {
            return new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            http_response_code(500);

            echo "<div style='text-align: center; padding: 80px 20px; font-family: \"Times New Roman\", serif; background-color: #FBF9F6; min-height: 100vh; box-sizing: border-box;'>";
            echo "    <h1 style='color: #4A3E3D; font-size: 28pt; font-weight: normal; margin-bottom: 20px;'>Hệ thống hiện đang bảo trì</h1>";
            echo "    <p style='color: #8A7E7C; font-size: 14pt; max-width: 600px; margin: 0 auto; line-height: 1.6;'>";
            echo "        Chúng tôi đang tiến hành nâng cấp định kỳ hệ thống cơ sở dữ liệu để tối ưu bảo mật. ";
            echo "        Vui lòng quay lại sau ít phút. Xin lỗi bà vì sự bất tiện này!";
            echo "    </p>";
            echo "    <div style='margin-top: 40px; color: #A38A75; font-size: 12pt;'>Mã phản hồi hệ thống: HTTP 500 Internal Server Error</div>";
            echo "</div>";

            exit;
        }
    }
}