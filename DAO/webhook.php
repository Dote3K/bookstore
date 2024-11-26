    <?php
require '../connect.php';

// Nhận dữ liệu từ webhook
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No data']);
    exit;
}

// Lưu thông tin giao dịch vào bảng transactions
$gateway = $data['gateway']; // Brand name của ngân hàng
$transaction_date = $data['transactionDate']; // Thời gian xảy ra giao dịch phía ngân hàng
$account_number = $data['accountNumber']; // Số tài khoản ngân hàng
$amount_in = $data['transferAmount']; // Số tiền giao dịch
$transaction_content = $data['content']; // Nội dung chuyển khoản
$reference_number = $data['referenceCode']; // Mã tham chiếu
$body = $data['description']; // Toàn bộ nội dung tin notify ngân hàng

// Tách mã đơn hàng từ nội dung chuyển khoản
preg_match('/DH(\d+)/', $transaction_content, $matches);
$ma_don_hang = isset($matches[1]) ? intval($matches[1]) : 0;

if ($ma_don_hang <= 0) {
    echo json_encode(['success' => false, 'message' => 'không tìm thấy mã đơn hàng trong transactions']);
    exit;
}

// Kiểm tra đơn hàng có tồn tại và trạng thái là 'CHO_THANH_TOAN'
$stmt = $conn->prepare("SELECT * FROM donhang WHERE ma_don_hang = ? AND tong = ? AND trang_thai = 'CHO_THANH_TOAN'");
$stmt->bind_param("id", $ma_don_hang, $amount_in);
$stmt->execute();
$result = $stmt->get_result();
$don_hang = $result->fetch_assoc();

if (!$don_hang) {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy đơn hàng hoặc đơn hàng đã được xử lý']);
    exit;
}

$conn->begin_transaction();

try {
    // Cập nhật trạng thái đơn hàng thành 'DA_THANH_TOAN'
    $stmt = $conn->prepare("UPDATE donhang SET trang_thai = 'DA_THANH_TOAN' WHERE ma_don_hang = ?");
    $stmt->bind_param("i", $ma_don_hang);
    $stmt->execute();


    // Lưu thông tin giao dịch vào bảng transactions
    $stmt = $conn->prepare("INSERT INTO transactions (ma_don_hang, gateway, transaction_date, account_number, amount, transaction_content, reference_number, body) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssdsss", $ma_don_hang, $gateway, $transaction_date, $account_number, $amount_in, $transaction_content, $reference_number, $body);
    $stmt->execute();

    // Lấy thông tin giỏ hàng tạm
    $stmt = $conn->prepare("SELECT * FROM gio_hang_tam WHERE ma_don_hang = ?");
    $stmt->bind_param("i", $ma_don_hang);
    $stmt->execute();
    $result = $stmt->get_result();

    // Thêm chi tiết đơn hàng và trừ kho
    while ($item = $result->fetch_assoc()) {
        $ma_sach = $item['ma_sach'];
        $so_luong = $item['so_luong'];

        // Thêm chi tiết đơn hàng
        $stmt_insert = $conn->prepare("INSERT INTO chitietdonhang (ma_don_hang, ma_sach, so_luong) VALUES (?, ?, ?)");
        $stmt_insert->bind_param("iii", $ma_don_hang, $ma_sach, $so_luong);
        $stmt_insert->execute();

        // Cập nhật số lượng sách trong kho
        $stmt_update = $conn->prepare("UPDATE sach SET so_luong = so_luong - ? WHERE ma_sach = ?");
        $stmt_update->bind_param("ii", $so_luong, $ma_sach);
        $stmt_update->execute();
    }

    // Xóa giỏ hàng tạm
    $stmt = $conn->prepare("DELETE FROM gio_hang_tam WHERE ma_don_hang = ?");
    $stmt->bind_param("i", $ma_don_hang);
    $stmt->execute();

    $conn->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Error processing transaction: ' . $e->getMessage()]);
}
?>
