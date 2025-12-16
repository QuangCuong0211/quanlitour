<?php

/* =====================================================
   KẾT NỐI DATABASE (PDO)
===================================================== */
function connectDB()
{
    static $conn = null;

    if ($conn === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8";
            $conn = new PDO($dsn, DB_USERNAME, DB_PASSWORD);

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    return $conn;
}

/* =====================================================
   UPLOAD / DELETE FILE
===================================================== */
function uploadFile($file, $folderSave)
{
    if (empty($file['name'])) return null;

    $fileName = rand(10000, 99999) . '_' . basename($file['name']);
    $pathStorage = $folderSave . $fileName;
    $pathSave = PATH_ROOT . $pathStorage;

    if (move_uploaded_file($file['tmp_name'], $pathSave)) {
        return $pathStorage;
    }
    return null;
}

function deleteFile($file)
{
    if (!$file) return;
    $path = PATH_ROOT . $file;
    if (file_exists($path)) {
        unlink($path);
    }
}

/* =====================================================
   PDO HELPER FUNCTIONS (DÙNG CHO MODELS)
===================================================== */

/* ---- SELECT nhiều dòng ---- */
function pdo_query($sql)
{
    $params = array_slice(func_get_args(), 1);
    try {
        $stmt = connectDB()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "PDO Query Error: " . $e->getMessage();
        return [];
    }
}

/* ---- SELECT 1 dòng ---- */
function pdo_query_one($sql)
{
    $params = array_slice(func_get_args(), 1);
    try {
        $stmt = connectDB()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    } catch (PDOException $e) {
        echo "PDO Query One Error: " . $e->getMessage();
        return null;
    }
}

/* ---- SELECT 1 giá trị (COUNT, SUM, ...) ---- */
function pdo_query_value($sql)
{
    $params = array_slice(func_get_args(), 1);
    try {
        $stmt = connectDB()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "PDO Query Value Error: " . $e->getMessage();
        return null;
    }
}

/* ---- INSERT / UPDATE / DELETE ---- */
function pdo_execute($sql)
{
    $params = array_slice(func_get_args(), 1);
    try {
        $conn = connectDB();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        $type = strtolower(strtok(trim($sql), ' '));
        if ($type === 'insert') {
            return $conn->lastInsertId();
        }

        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "PDO Execute Error: " . $e->getMessage();
        return false;
    }
}
