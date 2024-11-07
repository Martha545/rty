<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('../config.php');
require_once __DIR__ . '/../vendor/autoload.php';

;

class Master extends DBConnection {
    private $settings;

    public function __construct() {
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
    }

    public function __destruct() {
        parent::__destruct();
    }

    function capture_err() {
        if (!$this->conn->error) {
            return false;
        } else {
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
            return json_encode($resp);
            exit;
        }
    }

    function save_service() {
        $_POST['description'] = htmlentities($_POST['description']);
        extract($_POST);
        $data = "";
        
        foreach ($_POST as $k => $v) {
            if (!in_array($k, array('id'))) {
                $v = $this->conn->real_escape_string($v);
                if (!empty($data)) $data .= ",";
                $data .= " `{$k}`='{$v}' ";
            }
        }
        
        if (empty($id)) {
            $sql = "INSERT INTO `service_list` SET {$data} ";
        } else {
            $sql = "UPDATE `service_list` SET {$data} WHERE id = '{$id}' ";
        }

        $check = $this->conn->query("SELECT * FROM `service_list` WHERE `name`='{$name}' " . ($id > 0 ? " AND id != '{$id}'" : ""))->num_rows;
        if ($check > 0) {
            $resp['status'] = 'failed';
            $resp['msg'] = "Service Name Already Exists.";
        } else {
            $save = $this->conn->query($sql);
            if ($save) {
                $rid = !empty($id) ? $id : $this->conn->insert_id;
                $resp['status'] = 'success';
                $resp['msg'] = empty($id) ? "Service details successfully added." : "Service details have been updated successfully.";
            } else {
                $resp['status'] = 'failed';
                $resp['msg'] = "An error occurred.";
                $resp['err'] = $this->conn->error . "[{$sql}]";
            }
        }
        
        if ($resp['status'] == 'success') {
            $this->settings->set_flashdata('success', $resp['msg']);
        }
        return json_encode($resp);
    }

    function delete_service() {
        extract($_POST);
        $del = $this->conn->query("DELETE FROM `service_list` WHERE id = '{$id}'");
        if ($del) {
            $resp['status'] = 'success';
            $this->settings->set_flashdata('success', "Service has been deleted successfully.");
        } else {
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);
    }

    function send_enrollment_email($parent_email, $child_name, $status) {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
    
        try {
            // Server settings
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'sandbox.smtp.mailtrap.io';                       // Set the SMTP server (e.g., Gmail, SendGrid, etc.)
            $mail->SMTPAuth = true;                                // Enable SMTP authentication
            $mail->Username = '7be1985bfbaf4c';             // SMTP username
            $mail->Password = 'c6d600b2bd5c10';                // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // Enable TLS encryption
            $mail->Port = 2525;                                     // TCP port to connect to
    
            // Recipients
            $mail->setFrom('info@babycareXYZ.com', 'CDCMS');
            $mail->addAddress($parent_email);                       // Add the parent's email address
    
            // Content
            $mail->isHTML(true);                                    // Set email format to HTML
            $mail->Subject = 'Enrollment Confirmation';
            $mail->Body    = "Hello, <br><br>Your child <b>$child_name</b> has been successfully enrolled. Status: <b>$status</b><br><br>Thank you for using our service.";
    
            // Send email
            $mail->send();
            return true;
        } catch (Exception $e) {
            // Return error message if email fails to send
            return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    function save_babysitter() {
        // Ensure required fields are provided (adjust as needed)
        if (empty($_POST['firstname']) || empty($_POST['lastname'])) {
            return json_encode(['status' => 'failed', 'msg' => 'Required fields are missing.']);
        }

        // Get values from $_POST
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $skills = $_POST['skills'];
        $years_experience = $_POST['years_experience'];
        $other = $_POST['other'];

        // Insert into babysitter_list
        $sql_list = "INSERT INTO `babysitter_list` (`code`, `fullname`, `status`, `date_created`, `date_updated`) 
                     VALUES ('BYS-".time()."', '$firstname $lastname', 1, NOW(), NOW())";
        if ($this->conn->query($sql_list) === TRUE) {
            $babysitter_id = $this->conn->insert_id; // Get the last inserted id

            // Prepare details for babysitter_details
            $details = [
                ['babysitter_id' => $babysitter_id, 'meta_field' => 'firstname', 'meta_value' => $firstname],
                ['babysitter_id' => $babysitter_id, 'meta_field' => 'lastname', 'meta_value' => $lastname],
                ['babysitter_id' => $babysitter_id, 'meta_field' => 'gender', 'meta_value' => $gender],
                ['babysitter_id' => $babysitter_id, 'meta_field' => 'email', 'meta_value' => $email],
                ['babysitter_id' => $babysitter_id, 'meta_field' => 'contact', 'meta_value' => $contact],
                ['babysitter_id' => $babysitter_id, 'meta_field' => 'address', 'meta_value' => $address],
                ['babysitter_id' => $babysitter_id, 'meta_field' => 'skills', 'meta_value' => $skills],
                ['babysitter_id' => $babysitter_id, 'meta_field' => 'years_experience', 'meta_value' => $years_experience],
                ['babysitter_id' => $babysitter_id, 'meta_field' => 'other', 'meta_value' => $other],
            ];

            // Insert into babysitter_details
            foreach ($details as $detail) {
                $sql_detail = "INSERT INTO `babysitter_details` (`babysitter_id`, `meta_field`, `meta_value`) 
                               VALUES ('{$detail['babysitter_id']}', '{$detail['meta_field']}', '{$detail['meta_value']}')";
                $this->conn->query($sql_detail);
            }

            $response = array('status' => 'success', 'msg' => 'Babysitter saved successfully!');
        } else {
            $response = array('status' => 'failed', 'msg' => "An error occurred while saving babysitter. Error: " . $this->conn->error);
        }

        // Return the response as JSON
        echo json_encode($response);
        exit;
    }

    function delete_babysitter() {
		// Ensure the ID is provided
		if (empty($_POST['id'])) {
			return json_encode(['status' => 'failed', 'msg' => 'No ID provided.']);
		}
	
		// Extract the ID
		$id = $_POST['id'];
	
		// Begin a transaction
		$this->conn->begin_transaction();
		try {
			// Delete from babysitter_details
			$del_details = $this->conn->query("DELETE FROM `babysitter_details` WHERE `babysitter_id` = '{$id}'");
	
			// Delete from babysitter_list
			$del_list = $this->conn->query("DELETE FROM `babysitter_list` WHERE `id` = '{$id}'");
	
			// Commit the transaction if both deletes were successful
			if ($del_details && $del_list) {
				$this->conn->commit();
				$resp['status'] = 'success';
				$resp['msg'] = "Babysitter has been deleted successfully.";
			} else {
				throw new Exception("Error deleting babysitter.");
			}
		} catch (Exception $e) {
			// Rollback the transaction if something went wrong
			$this->conn->rollback();
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occurred while deleting the babysitter. Error: " . $this->conn->error;
		}
	
		return json_encode($resp);
	}
	
    function save_enrollment() {
        // Ensure required fields are provided
        if (empty($_POST['child_firstname']) || empty($_POST['child_lastname']) || 
            empty($_POST['parent_firstname']) || empty($_POST['parent_lastname']) || 
            empty($_POST['parent_contact']) || empty($_POST['parent_email'])) {
            return json_encode(['status' => 'failed', 'msg' => 'Required fields are missing.']);
        }
    
        // Extract necessary fields
        $child_firstname = $_POST['child_firstname'];
        $child_middlename = $_POST['child_middlename'] ?? '';
        $child_lastname = $_POST['child_lastname'];
        $gender = $_POST['gender'] ?? '';
        $child_dob = $_POST['child_dob'] ?? '';
        $parent_firstname = $_POST['parent_firstname'];
        $parent_middlename = $_POST['parent_middlename'] ?? '';
        $parent_lastname = $_POST['parent_lastname'];
        $parent_contact = $_POST['parent_contact'];
        $parent_email = $_POST['parent_email'];
        $address = $_POST['address'] ?? '';
    
        // Build full names
        $child_fullname = trim("{$child_firstname} {$child_middlename} {$child_lastname}");
        $parent_fullname = trim("{$parent_firstname} {$parent_middlename} {$parent_lastname}");
    
        // Insert into enrollment_list
        $sql_enrollment = "INSERT INTO enrollment_list (code, child_fullname, parent_fullname, status, date_created, date_updated) VALUES (?, ?, ?, 'active', NOW(), NOW())";
        $stmt_enrollment = $this->conn->prepare($sql_enrollment);
    
        // Generate a unique code for enrollment
        $code = uniqid(); // or however you want to generate this
        $stmt_enrollment->bind_param('sss', $code, $child_fullname, $parent_fullname);
    
        if ($stmt_enrollment->execute()) {
            $enrollment_id = $this->conn->insert_id; // Get the last inserted ID
    
            // Insert into enrollment_details
            $details_sql = "INSERT INTO enrollment_details (enrollment_id, meta_field, meta_value) VALUES (?, 'gender', ?), (?, 'dob', ?), (?, 'address', ?)";
            $details_stmt = $this->conn->prepare($details_sql);
            $details_stmt->bind_param('issssi', $enrollment_id, $gender, $enrollment_id, $child_dob, $enrollment_id, $address);
    
            // Execute the statement
            if ($details_stmt->execute()) {
                // After successful enrollment, send the email to the parent
                $status = 'Confirmed'; // Assuming enrollment status is 'Confirmed'
                $email_sent = $this->send_enrollment_email($parent_email, $child_fullname, $status);
    
                if ($email_sent === true) {
                    return json_encode(['status' => 'success', 'msg' => 'Enrollment saved and email sent successfully.']);
                } else {
                    return json_encode(['status' => 'success', 'msg' => 'Enrollment saved, but email failed to send.']);
                }
            } else {
                return json_encode(['status' => 'failed', 'msg' => 'Failed to save enrollment details. Error: ' . $this->conn->error]);
            }
        } else {
            return json_encode(['status' => 'failed', 'msg' => 'Failed to save enrollment. Error: ' . $this->conn->error]);
        }
    }
    

    function update_status(){
        extract($_POST);
        $id = isset($id) ? (int)$id : 0;
        $status = isset($status) ? (int)$status : 0;
    
        $update = $this->conn->prepare("UPDATE enrollment_list SET status = ? WHERE id = ?");
        $update->bind_param("ii", $status, $id);
    
        if($update->execute()){
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "msg" => "Failed to update status."]);
        }
    }
    
    
    
    
	function delete_enrollment() {
        // Ensure the ID is provided
        if (empty($_POST['id'])) {
            return json_encode(['status' => 'failed', 'msg' => 'No ID provided.']);
        }

        // Extract the ID
        $id = $_POST['id'];

        // Attempt to delete the enrollment record
        $del = $this->conn->query("DELETE FROM `enrollment_list` WHERE `id` = '{$id}'");

        if ($del) {
            $resp['status'] = 'success';
            $resp['msg'] = "Enrollment record has been deleted successfully.";
            $this->settings->set_flashdata('success', "Enrollment has been deleted successfully.");
        } else {
            $resp['status'] = 'failed';
            $resp['msg'] = "An error occurred while deleting enrollment. Error: " . $this->conn->error;
        }

        return json_encode($resp);
    }
	
	

    function save_attendance() {
        // Ensure required fields are provided
        if (empty($_POST['enrollment_id']) || empty($_POST['date']) || empty($_POST['status'])) {
            return json_encode(['status' => 'failed', 'msg' => 'Required fields are missing.']);
        }
    
        extract($_POST);
    
        // Escape input values
        $data = [];
        foreach ($_POST as $k => $v) {
            if (!in_array($k, ['id'])) {
                $data[$k] = $this->conn->real_escape_string($v);
            }
        }
    
        // Check if the enrollment_id exists in the enrollment_list table
        $checkEnrollment = $this->conn->query("SELECT 1 FROM `enrollment_list` WHERE `id` = '{$data['enrollment_id']}'");
    
        if ($checkEnrollment->num_rows === 0) {
            return json_encode(['status' => 'failed', 'msg' => 'Enrollment ID does not exist in the enrollment list.']);
        }
    
        // Check for existing attendance record
        $check = $this->conn->query("SELECT * FROM `attendance` WHERE `date` = '{$data['date']}' AND `enrollment_id` = '{$data['enrollment_id']}'")->num_rows;
    
        if ($check > 0) {
            // Update existing attendance
            $sql = "UPDATE `attendance` SET `date` = ?, `status` = ?, `notes` = ? WHERE `date` = ? AND `enrollment_id` = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('sssss', $data['date'], $data['status'], $data['notes'], $data['date'], $data['enrollment_id']);
        } else {
            // Insert new attendance record
            $sql = "INSERT INTO `attendance` (`enrollment_id`, `date`, `status`, `notes`) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('ssss', $data['enrollment_id'], $data['date'], $data['status'], $data['notes']);
        }
    
        // Execute the query and check for success
        if ($stmt->execute()) {
            $resp['status'] = 'success';
            $resp['msg'] = $check > 0 ? "Attendance updated successfully." : "Attendance recorded successfully.";
        } else {
            $resp['status'] = 'failed';
            $resp['msg'] = "An error occurred while saving attendance. Error: " . $stmt->error;
        }
    
        // Close the prepared statement
        $stmt->close();
    
        return json_encode($resp);
    }
    
    
    
    

	function delete_attendance() {
		// Ensure the ID is provided
		if (empty($_POST['id'])) {
			return json_encode(['status' => 'failed', 'msg' => 'No ID provided.']);
		}
	
		// Extract the ID
		$id = $_POST['id'];
	
		// Attempt to delete the attendance record
		$del = $this->conn->query("DELETE FROM `attendance` WHERE `id` = '{$id}'");
	
		if ($del) {
			$resp['status'] = 'success';
			$resp['msg'] = "Attendance record has been deleted successfully.";
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occurred while deleting attendance. Error: " . $this->conn->error;
		}
	
		return json_encode($resp);
	}

    function create_invoice($enrollment_id, $service_ids) {
        // Step 1: Retrieve enrollment details (e.g., child and parent names)
        $enrollment_query = $this->conn->prepare("SELECT child_fullname, parent_fullname FROM enrollment_list WHERE id = ?");
        $enrollment_query->bind_param("i", $enrollment_id);
        $enrollment_query->execute();
        $result = $enrollment_query->get_result();
        $enrollment = $result->fetch_assoc();
    
        if (!$enrollment) {
            return ["status" => "error", "msg" => "Enrollment not found."];
        }
    
        // Step 2: Calculate the total amount by fetching service details from the service_list table
        $total_amount = 0;
        $items = [];
        foreach ($service_ids as $service_id) {
            $service_query = $this->conn->prepare("SELECT name, description, price FROM service_list WHERE id = ?");
            $service_query->bind_param("i", $service_id);
            $service_query->execute();
            $service_result = $service_query->get_result();
            $service = $service_result->fetch_assoc();
    
            if ($service) {
                $total_amount += $service['price'];
                $items[] = [
                    'service_id' => $service_id,
                    'description' => $service['description'],
                    'amount' => $service['price']
                ];
            }
        }
    
        // Step 3: Insert into invoices table
        $invoice_query = $this->conn->prepare("INSERT INTO invoices (enrollment_id, total_amount, status, date_created) VALUES (?, ?, 0, NOW())");
        $invoice_query->bind_param("id", $enrollment_id, $total_amount);
        if ($invoice_query->execute()) {
            $invoice_id = $this->conn->insert_id; // Get the last inserted invoice ID
    
            // Step 4: Insert each service item into invoice_items table
            foreach ($items as $item) {
                $item_query = $this->conn->prepare("INSERT INTO invoice_items (invoice_id, service_id, description, amount) VALUES (?, ?, ?, ?)");
                $item_query->bind_param("iisd", $invoice_id, $item['service_id'], $item['description'], $item['amount']);
                $item_query->execute();
            }
    
            return ["status" => "success", "msg" => "Invoice created successfully."];
        } else {
            return ["status" => "error", "msg" => "Failed to create invoice."];
        }
    }

    function save_billing() {
        // Debug: Log entire POST data for troubleshooting
        error_log("POST Data: " . print_r($_POST, true));
    
        // Ensure required fields are provided, but amount is not required for 'Pending' status
        if (empty($_POST['enrollment_id']) || !isset($_POST['status']) || empty($_POST['service_id'])) {
            return json_encode(['status' => 'failed', 'msg' => 'Required fields are missing.']);
        }
    
        // Convert status to string to avoid comparison issues
        $status = (string)$_POST['status'];
    
        // Debug: Log received status for troubleshooting
        error_log("Received status: " . $status);
    
        // If status is '1' (Paid), ensure amount is provided
        if ($status === '1' && empty($_POST['amount'])) {
            return json_encode(['status' => 'failed', 'msg' => 'Amount is required for Paid status.']);
        }
    
        // Extract necessary fields
        $enrollment_id = $_POST['enrollment_id'];
        $service_id = $_POST['service_id'];
        $date = $_POST['date'] ?? date('Y-m-d');
        $amount = $_POST['amount'] ?? null;
    
        // Check if status is either '0' (Pending) or '1' (Paid) for validity
        if ($status !== '0' && $status !== '1') {
            return json_encode(['status' => 'failed', 'msg' => 'Invalid status provided.']);
        }
    
        // Start a transaction to ensure consistency
        $this->conn->begin_transaction();
    
        try {
            // If no invoice_id is provided, insert a new invoice
            if (empty($_POST['invoice_id'])) {
                $invoice_sql = "INSERT INTO invoices (enrollment_id, total_amount, status, date_created) VALUES (?, ?, ?, NOW())";
                $stmt_invoice = $this->conn->prepare($invoice_sql);
                $stmt_invoice->bind_param('ids', $enrollment_id, $amount, $status);
    
                if (!$stmt_invoice->execute()) {
                    throw new Exception("Error creating invoice: " . $this->conn->error);
                }
                $invoice_id = $this->conn->insert_id;
            } else {
                $invoice_id = $_POST['invoice_id'];
            }
    
            // Insert into billing table, including service_id
            $sql_billing = "INSERT INTO billing (enrollment_id, invoice_id, date_created, amount, status, service_id, date_updated) VALUES (?, ?, ?, ?, ?, ?, NOW())";
            $stmt_billing = $this->conn->prepare($sql_billing);
    
            $stmt_billing->bind_param('iisssi', $enrollment_id, $invoice_id, $date, $amount, $status, $service_id);
    
            if (!$stmt_billing->execute()) {
                throw new Exception("Error inserting billing record: " . $this->conn->error);
            }
    
            // Commit transaction after successful insertions
            $this->conn->commit();
    
            return json_encode(['status' => 'success', 'msg' => 'Billing record saved successfully.']);
    
        } catch (Exception $e) {
            // Log the error for debugging purposes
            error_log("Error: " . $e->getMessage());
    
            // Rollback in case of error
            $this->conn->rollback();
            return json_encode(['status' => 'failed', 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }
    
       
    
    
    function delete_billing() {
        // Ensure the ID is provided
        if (empty($_POST['id'])) {
            return json_encode(['status' => 'failed', 'msg' => 'No ID provided.']);
        }
    
        // Extract the ID
        $id = $_POST['id'];
    
        // Start a transaction to ensure consistency
        $this->conn->begin_transaction();
    
        try {
            // First, get the invoice_id from the billing record
            $sql_get_invoice = "SELECT invoice_id FROM billing WHERE id = ?";
            $stmt_get_invoice = $this->conn->prepare($sql_get_invoice);
            $stmt_get_invoice->bind_param('i', $id);
            $stmt_get_invoice->execute();
            $stmt_get_invoice->bind_result($invoice_id);
            $stmt_get_invoice->fetch();
            $stmt_get_invoice->close();
    
            // If an invoice_id is found, delete the related invoice record
            if ($invoice_id) {
                $sql_delete_invoice = "DELETE FROM invoices WHERE id = ?";
                $stmt_delete_invoice = $this->conn->prepare($sql_delete_invoice);
                $stmt_delete_invoice->bind_param('i', $invoice_id);
                if (!$stmt_delete_invoice->execute()) {
                    throw new Exception("Error deleting invoice: " . $this->conn->error);
                }
            }
    
            // Now, delete the billing record
            $del = $this->conn->prepare("DELETE FROM billing WHERE id = ?");
            $del->bind_param('i', $id);
            if (!$del->execute()) {
                throw new Exception("Error deleting billing record: " . $this->conn->error);
            }
    
            // Commit transaction after successful deletions
            $this->conn->commit();
    
            $resp['status'] = 'success';
            $resp['msg'] = "Billing record and associated invoice have been deleted successfully.";
            return json_encode($resp);
    
        } catch (Exception $e) {
            // Rollback in case of error
            $this->conn->rollback();
            return json_encode(['status' => 'failed', 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }
    
   
    // Function definition to get attendance details
    function get_attendance_details() {
        // Ensure required fields are provided (in this case, ID)
        if (empty($_POST['id'])) {
            return json_encode(['status' => 'failed', 'msg' => 'ID is missing.']);
        }
    
        // Get ID from the POST data
        $id = $_POST['id'];
    
        // Prepare the query to fetch the attendance details based on the ID
        $sql = "SELECT a.*, e.child_fullname, e.parent_fullname
                FROM attendance a
                INNER JOIN enrollment_list e ON a.enrollment_id = e.id
                WHERE a.id = '$id'";
    
        // Execute the query
        $qry = $this->conn->query($sql);
    
        // Check if any record is found
        if ($qry->num_rows > 0) {
            $row = $qry->fetch_assoc();
            
            // Return the data as JSON
            $response = [
                'status' => 'success',
                'data' => $row
            ];
        } else {
            // If no record is found
            $response = [
                'status' => 'failed',
                'msg' => 'No attendance record found for the given ID.'
            ];
        }
    
        // Return the response as JSON
        echo json_encode($response);
        exit;
    }
       
}



    	


$Master = new Master();
$action = isset($_GET['f']) ? $_GET['f'] : ''; // Changed to use GET parameter

switch ($action) {
    case 'save_service':
        echo $Master->save_service();
        break;
    case 'delete_service':
        echo $Master->delete_service();
        break;
    case 'send_enrollment_email':
        echo $Master->send_enrollment_email();
        break;
    case 'save_babysitter':
        echo $Master->save_babysitter();
        break;
    case 'delete_babysitter':
        echo $Master->delete_babysitter();
        break;
    case 'save_enrollment':
        echo $Master->save_enrollment();
        break;
    case 'delete_enrollment':
        echo $Master->delete_enrollment();
        break;
    case 'save_attendance':
        echo $Master->save_attendance();
        break;
	case 'delete_attendance':
		echo $Master->delete_attendance();
		break;
    case 'update_status':
        echo $Master->update_status();
        break;
    case 'create_invoice':
        echo $Master->create_invoice();
        break;
    case 'save_billing':
        echo $Master->save_billing();
        break;
    case 'delete_billing':
        echo $Master->delete_billing();
        break;
    case 'get_attendance_details':
        echo $Master->get_attendance_details();
        break;         
    default:
        echo json_encode(['status' => 'failed', 'msg' => 'Invalid action.']);
        break;
}
