<?php
session_start();
require 'db.php';

// ====================================================================
// HANDLE CREATE
// ====================================================================
if (isset($_POST['action']) && $_POST['action'] == "create") {
    $sql = "INSERT INTO recap (tanggal, notes, movie, sports, new_program, program_special, series, typing_user, typing_time)
            VALUES (:tanggal, :notes, :movie, :sports, :new_program, :program_special, :series, :typing_user, NOW())";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':tanggal' => $_POST['tanggal'],
        ':notes' => $_POST['notes'],
        ':movie' => $_POST['movie'],
        ':sports' => $_POST['sports'],
        ':new_program' => $_POST['new_program'],
        ':program_special' => $_POST['program_special'],
        ':series' => $_POST['series'],
        ':typing_user' => $_POST['typing_user'],
    ]);

    echo "<script>localStorage.setItem('alert','added');</script>";
    echo "<script>location.href='recap.php'</script>";
    exit;
}

// ====================================================================
// HANDLE UPDATE
// ====================================================================
if (isset($_POST['action']) && $_POST['action'] == "update") {
    $sql = "UPDATE recap SET 
            tanggal=:tanggal,
            notes=:notes,
            movie=:movie,
            sports=:sports,
            new_program=:new_program,
            program_special=:program_special,
            series=:series,
            typing_user=:typing_user,
            typing_time=NOW()
            WHERE id=:id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id' => $_POST['id'],
        ':tanggal' => $_POST['tanggal'],
        ':notes' => $_POST['notes'],
        ':movie' => $_POST['movie'],
        ':sports' => $_POST['sports'],
        ':new_program' => $_POST['new_program'],
        ':program_special' => $_POST['program_special'],
        ':series' => $_POST['series'],
        ':typing_user' => $_POST['typing_user'],
    ]);

    echo "<script>localStorage.setItem('alert','updated');</script>";
    echo "<script>location.href='recap.php'</script>";
    exit;
}

// ====================================================================
// HANDLE DELETE
// ====================================================================
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM recap WHERE id=?");
    $stmt->execute([$_GET['delete']]);

    echo "<script>localStorage.setItem('alert','deleted');</script>";
    echo "<script>location.href='recap.php'</script>";
    exit;
}

// ====================================================================
// FILTER + SEARCH + PAGINATION
// ====================================================================

// PAGINATION
$itemsPerPage = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $itemsPerPage;

// FILTER
$where = "WHERE 1=1";
$params = [];

// FILTER TANGGAL
if (!empty($_GET['filter_date'])) {
    $where .= " AND tanggal = :tanggal";
    $params[':tanggal'] = $_GET['filter_date'];
}

// SEARCH MULTI KOLOM
if (!empty($_GET['search'])) {
    $where .= " AND (notes LIKE :s OR movie LIKE :s OR sports LIKE :s OR new_program LIKE :s 
                     OR program_special LIKE :s OR series LIKE :s)";
    $params[':s'] = "%" . $_GET['search'] . "%";
}

// HITUNG TOTAL DATA
$totalStmt = $pdo->prepare("SELECT COUNT(*) FROM recap $where");
$totalStmt->execute($params);
$total = $totalStmt->fetchColumn();
$totalPages = ceil($total / $itemsPerPage);

// GET DATA
$sql = "SELECT * FROM recap $where ORDER BY tanggal DESC LIMIT $offset, $itemsPerPage";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Highlight Admin</title>
    <link rel="shortcut icon" href="icons.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-light">

<div class="container mt-4">

    <h3 class="text-center mb-4">Highlight Competitor</h3>

    <!-- FILTER -->
    <form method="GET" class="row mb-3">
        <div class="col-md-3">
            <input type="date" name="filter_date" class="form-control" value="<?= $_GET['filter_date'] ?? '' ?>">
        </div>

        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Cari teks..." value="<?= $_GET['search'] ?? '' ?>">
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>

        <div class="col-md-2">
            <a href="crud.php" class="btn btn-secondary w-100">Reset</a>
        </div>
    </form>

    <!-- BUTTON TAMBAH -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Data</button>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-dark">
                <tr>
                    <!-- <th>ID</th> -->
                    <th>Tanggal</th>
                    <th>Notes</th>
                    <th>Movie</th>
                    <th>Sports</th>
                    <th>New Program</th>
                    <th>Program Special</th>
                    <th>Series</th>
                    <th>Typing User</th>
                    <th>Typing Time</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($data as $row): ?>
                <tr>
                    <!-- <td><?= $row['id']; ?></td> -->
                    <td><?= $row['tanggal']; ?></td>
                    <td><?= $row['notes']; ?></td>
                    <td><?= $row['movie']; ?></td>
                    <td><?= $row['sports']; ?></td>
                    <td><?= $row['new_program']; ?></td>
                    <td><?= $row['program_special']; ?></td>
                    <td><?= $row['series']; ?></td>
                    <td><?= $row['typing_user']; ?></td>
                    <td><?= $row['typing_time']; ?></td>

                    <td>
                        <button class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>

                        <a onclick="return confirmDelete(<?= $row['id'] ?>);" 
                           class="btn btn-danger btn-sm text-white">Hapus</a>
                    </td>
                </tr>

                <!-- EDIT MODAL -->
                <div class="modal fade" id="editModal<?= $row['id'] ?>">
                    <div class="modal-dialog modal-lg">
                        <form method="POST" class="modal-content">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">

                            <div class="modal-header">
                                <h5>Edit Data</h5>
                            </div>

                            <div class="modal-body">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <label>Tanggal</label>
                                        <input type="date" name="tanggal" class="form-control" value="<?= $row['tanggal'] ?>" required>
                                    </div>

                                    <?php
                                    $fields = ['notes','movie','sports','new_program','program_special','series'];
                                    foreach ($fields as $f):
                                    ?>
                                    <div class="col-md-6">
                                        <label><?= ucfirst(str_replace('_',' ',$f)) ?></label>
                                        <textarea name="<?= $f ?>" class="form-control"><?= $row[$f] ?></textarea>
                                    </div>
                                    <?php endforeach; ?>

                                    <div class="col-md-6">
                                        <label>Typing User</label>
                                        <input type="text" name="typing_user" class="form-control" value="<?= $row['typing_user'] ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <nav>
        <ul class="pagination justify-content-center">

            <?php for ($i=1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($page==$i?'active':'') ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= $_GET['search'] ?? '' ?>&filter_date=<?= $_GET['filter_date'] ?? '' ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

        </ul>
    </nav>

</div>

<!-- ADD MODAL -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">
        <form method="POST" class="modal-content">
            <input type="hidden" name="action" value="create">

            <div class="modal-header">
                <h5>Tambah Data</h5>
            </div>

            <div class="modal-body">
                <div class="row g-2">

                    <div class="col-md-4">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>

                    <?php
                    $fields = ['notes','movie','sports','new_program','program_special','series'];
                    foreach ($fields as $f):
                    ?>
                    <div class="col-md-6">
                        <label><?= ucfirst(str_replace('_',' ',$f)) ?></label>
                        <textarea name="<?= $f ?>" class="form-control"></textarea>
                    </div>
                    <?php endforeach; ?>

                    <div class="col-md-6">
                        <label>Typing User</label>
                        <input type="text" name="typing_user" class="form-control">
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success">Tambah</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        icon: 'warning',
        title: 'Hapus data?',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = "crud.php?delete=" + id;
        }
    });
}

// SweetAlert Notif
let a = localStorage.getItem('alert');
if (a === 'added') Swal.fire('Sukses','Data berhasil ditambahkan','success');
if (a === 'updated') Swal.fire('Sukses','Data berhasil diperbarui','success');
if (a === 'deleted') Swal.fire('Sukses','Data berhasil dihapus','success');
localStorage.removeItem('alert');
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
