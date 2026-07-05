<?php
/** @var string $title */
/** @var string $content */
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Hệ thống Event CRM') ?></title>
    <style>
        :root {
            --bg-main: #FBF9F6;
            --bg-navbar: #F4EFEA;
            --text-primary: #4A3E3D;
            --text-muted: #8A7E7C;
            --accent: #A38A75;
            --accent-hover: #8C7561;
            --border-color: #EAE3DA;
            --white: #FFFFFF;
            --success: #6E8A6B;
            --danger: #C27D6B;
            --warning: #D9A752;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 14pt;
            background-color: var(--bg-main);
            color: var(--text-primary);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Thanh điều hướng nằm ngang phía trên tràn viền */
        header {
            background-color: var(--bg-navbar);
            padding: 15px 40px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-weight: bold;
            font-size: 18pt;
            color: var(--text-primary);
            text-decoration: none;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        nav a {
            color: var(--text-primary);
            text-decoration: none;
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background 0.2s;
        }

        nav a:hover {
            background-color: #EFE9E0;
        }

        nav a.active {
            background-color: #EFE9E0;
        }

        /* Vùng nội dung chính căn giữa */
        .container {
            padding: 40px;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            box-sizing: border-box;
            flex: 1;
        }

        /* Khung Card */
        .card {
            background: var(--white);
            border: 1px solid var(--border-color);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(74, 62, 61, 0.03);
            margin-bottom: 30px;
        }

        h1 {
            color: var(--text-primary);
            font-size: 24pt;
            margin-top: 0;
            font-weight: normal;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        /* Bảng hiển thị thông tin */
        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--white);
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            margin-top: 20px;
        }

        th {
            background-color: #F8F5F0;
            padding: 14px 16px;
            text-align: left;
            font-weight: bold;
            color: var(--text-primary);
            border-bottom: 2px solid var(--border-color);
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
        }

        tr:hover {
            background-color: #FDFDFD;
        }

        /* Button & Tương tác UI */
        .btn {
            background-color: var(--accent);
            color: var(--white);
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            font-size: 13pt;
            font-family: inherit;
            transition: background 0.2s;
        }

        .btn:hover {
            background-color: var(--accent-hover);
        }

        .btn-danger { background-color: var(--danger); }
        .btn-danger:hover { background-color: #A66453; }

        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11pt;
            font-weight: bold;
            display: inline-block;
        }
        .badge-blue { background-color: #E3F2FD; color: #0D47A1; }    
        .badge-red { background-color: #FFEBEE; color: #C62828; }     
        .badge-yellow { background-color: #FFFDE7; color: #F57F17; }  
        .badge-green { background-color: #E8F5E9; color: #2E7D32; }   

        /* Form Controls */
        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; }
        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 13pt;
            box-sizing: border-box;
            background-color: #FCFAF8;
            font-family: inherit;
        }
        .form-control:focus { outline: none; border-color: var(--accent); background-color: var(--white); }

        .alert { padding: 15px; margin-bottom: 25px; border-radius: 6px; border: 1px solid transparent; }
        .alert-success { background-color: #EAF2E8; color: #4A7042; border-color: #D1E5CC; }
        .alert-danger { background-color: #F9EBEB; color: #A64444; border-color: #F1D4D4; }
        
        .pagination { margin-top: 25px; display: flex; gap: 8px; }
        .pagination a { padding: 8px 16px; border: 1px solid var(--border-color); text-decoration: none; color: var(--text-primary); border-radius: 4px; }
        .pagination a.active { background-color: var(--accent); color: var(--white); border-color: var(--accent); }
    </style>
</head>
<body>

    <?php partial('nav'); ?>

    <div class="container">
        <?php partial('flash'); ?>
        <?= $content ?>
    </div>

</body>
</html>