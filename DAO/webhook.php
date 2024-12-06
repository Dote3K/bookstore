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
    echo json_encode(['success' => false, 'message' => 'Khong tim thay don hang hoac don hang da duoc xu ly']);
    exit;
}

$conn->begin_transaction();

try {
    // Cập nhật trạng thái đơn hàng thành 'DA_THANH_TOAN'
    $stmt = $conn->prepare("UPDATE donhang SET trang_thai = 'DA_THANH_TOAN' WHERE ma_don_hang = ?");
    $stmt->bind_param("i", $ma_don_hang);
    $stmt->execute();

    $conn->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Error processing transaction: ' . $e->getMessage()]);
}
?>
