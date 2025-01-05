<?php
$conn = new mysqli('localhost', 'lsvbpnax_tokenl', 'YRXw6RrV829aPZzLDeP7', 'lsvbpnax_tokenl');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure IDs start at 1
$conn->query("SET @count = 0;");
$conn->query("UPDATE users SET id = @count := @count + 1;");
$conn->query("ALTER TABLE users AUTO_INCREMENT = 1;");

// Fetch all users
$result = $conn->query("SELECT id, username, email, is_approved FROM users");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['approve_user_id'])) {
        $user_id = $_POST['approve_user_id'];
        $conn->query("UPDATE users SET is_approved = 1 WHERE id = $user_id");
    } elseif (isset($_POST['unapprove_user_id'])) {
        $user_id = $_POST['unapprove_user_id'];
        $conn->query("UPDATE users SET is_approved = 0 WHERE id = $user_id");
    } elseif (isset($_POST['delete_user_id'])) {
        $user_id = $_POST['delete_user_id'];
        $conn->query("DELETE FROM users WHERE id = $user_id");
    } elseif (isset($_POST['edit_user_id'])) {
        $user_id = $_POST['edit_user_id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // If the password is provided, hash it and update it
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $conn->query("UPDATE users SET username = '$username', email = '$email', password = '$hashed_password' WHERE id = $user_id");
        } else {
            $conn->query("UPDATE users SET username = '$username', email = '$email' WHERE id = $user_id");
        }
    }
    header('Location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h1 class="text-center mb-4">Admin Panel</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td>
                        <?php echo $row['is_approved'] ? '<span class="badge bg-success">Approved</span>' : '<span class="badge bg-warning">Pending</span>'; ?>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <form method="POST">
                                <input type="hidden" name="<?php echo $row['is_approved'] ? 'unapprove_user_id' : 'approve_user_id'; ?>" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-<?php echo $row['is_approved'] ? 'warning' : 'primary'; ?> btn-sm">
                                    <?php echo $row['is_approved'] ? 'Unapprove' : 'Approve'; ?>
                                </button>
                            </form>
                            <form method="POST">
                                <input type="hidden" name="delete_user_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">Edit</button>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel<?php echo $row['id']; ?>">Edit User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST">
                                                <input type="hidden" name="edit_user_id" value="<?php echo $row['id']; ?>">
                                                <div class="mb-3">
                                                    <label for="username<?php echo $row['id']; ?>" class="form-label">Username</label>
                                                    <input type="text" class="form-control" id="username<?php echo $row['id']; ?>" name="username" value="<?php echo htmlspecialchars($row['username']); ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email<?php echo $row['id']; ?>" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email<?php echo $row['id']; ?>" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password<?php echo $row['id']; ?>" class="form-label">Password (Leave blank to keep unchanged)</label>
                                                    <input type="password" class="form-control" id="password<?php echo $row['id']; ?>" name="password">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
