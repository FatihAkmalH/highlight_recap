<?php include "db.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="shortcut icon" href="icons.png" type="image/x-icon">
<title>Highlight Competitor</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    body {
        background: #f7f2ff;
        overflow-x: hidden;
    }
    ::-webkit-scrollbar { width: 0; }
    .card-custom {
        background: #ffffffcc;
        backdrop-filter: blur(8px);
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    textarea { height: 130px; }
    #output.changed {
        background: #fff3a3;
        transition: background 1.5s ease;
    }
    /* #output.changed-text {
        color: blue;
    } */
</style>
</head>

<body class="p-3">

<div class="container">
    <h1 class="text-center mb-4">Highlight Competitor</h1>

    <div class="row g-4">

        <!-- LEFT SIDE -->
        <div class="col-lg-6">
            <div class="card card-custom p-4">

                <form id="recapForm">

                <div class="d-flex flex-wrap align-items-center gap-2 mt-2">

                    <div class="flex-grow-1">
                        <label class="fw-bold mb-1">Tanggal Recap</label>
                        <input type="date" class="form-control mb-3" id="tanggal" name="tanggal" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="fa-regular fa-floppy-disk"></i> Simpan
                    </button>

                    <button type="button" class="btn btn-warning mt-3" id="clearForm">
                        <i class="fa-solid fa-broom"></i> Clear Form
                    </button>

                    <button type="button" class="btn btn-danger mt-3" id="deleteRecap">
                        <i class="fa-solid fa-delete-left"></i> Hapus Data
                    </button>

                </div>

                    <label class="fw-bold">Notes</label>
                    <textarea class="form-control mb-3 border-secondary-subtle" name="notes"></textarea>

                    <label class="fw-bold">Movie</label>
                    <textarea class="form-control mb-3 border-secondary-subtle" name="movie"></textarea>

                    <label class="fw-bold">Sports</label>
                    <textarea class="form-control mb-3 border-secondary-subtle" name="sports"></textarea>

                    <label class="fw-bold">New Program</label>
                    <textarea class="form-control mb-3 border-secondary-subtle" name="new_program"></textarea>

                    <label class="fw-bold">Program Special</label>
                    <textarea class="form-control mb-3 border-secondary-subtle" name="program_special"></textarea>

                    <label class="fw-bold">Series</label>
                    <textarea class="form-control mb-3 border-secondary-subtle" name="series"></textarea>

                </form>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="col-lg-6">
            <div class="card card-custom p-4">

                <div class="d-flex flex-wrap align-items-center gap-2 mt-2">
                    <h5 class="fw-bold mb-2">Hasil Recap</h5>
                    <button class="btn btn-success" onclick="copyOutput()">
                        <i class="fa-regular fa-copy"></i> Copy Hasil
                    </button>
                    <button class="btn btn-secondary ms-2" id="changeNameBtn">
                        <i class="fa-solid fa-user-pen"></i> Ganti Nama
                    </button>
                    <div id="typingStatus" class="text-danger fw-bold mb-2"></div>
                </div>

                <pre id="output" style="white-space: pre-wrap;"></pre>

                <!-- <pre id="footNote"></pre> -->

            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>
// ========== FUNGSI POPUP INPUT NAMA ==========

function askUsername(force = false) {
    let name = localStorage.getItem("username");

    // kondisi force: popup muncul meskipun nama sudah ada
    if (force) name = "";

    // jika tidak ada nama → tampilkan popup
    if (!name || name.trim() === "" || name === "undefined" || name === "null") {

        Swal.fire({
            title: "Masukkan Nama Anda",
            input: "text",
            inputPlaceholder: "Masukkan Nama Kamu...",
            allowOutsideClick: false,
            allowEscapeKey: false,
            confirmButtonText: "Simpan",
            inputValidator: (value) => {
                if (!value.trim()) return "Nama tidak boleh kosong!";
            }
        }).then(result => {
            if (result.value) {
                localStorage.setItem("username", result.value.trim());
                sessionStorage.setItem("username", result.value.trim());

                // reload agar semua request membawa nama
                location.reload();
            }
        });
    } else {
        // simpan ke session juga, untuk jaga-jaga
        sessionStorage.setItem("username", name);
    }
}

// =============================================

// Paksa cek nama saat halaman dibuka
document.addEventListener("DOMContentLoaded", () => {
    askUsername(false);
});

$("#changeNameBtn").on("click", function () {
    askUsername(true); // force popup muncul
});

// ========== Save ================
$("#recapForm").on("submit", function(e){
    e.preventDefault();

    $.post("save.php", $(this).serialize(), function(res){
        Swal.fire("Berhasil!", "Recap telah disimpan.", "success");
        loadOutput();
    });
});

// ========== Load Output ke kanan ============
function loadOutput() {
    let tanggal = $("#tanggal").val();
    if (!tanggal) {
        $("#output").text("");
        return;
    }

    $.get("fetch.php", { tanggal: tanggal }, function(data){
        $("#output").text(data);
    });
}

// ========== Ketika tanggal diganti → isi form + tampilkan output ============
$("#tanggal").on("change", function () {
    let tgl = $(this).val();
    if (!tgl) return;

    $.get("get_one.php", { tanggal: tgl }, function (res) {
        let data = res;

        // Jika server kirim JSON string → parse
        if (typeof res === "string") {
            try { data = JSON.parse(res); } catch (e) { data = {}; }
        }

        if (data && Object.keys(data).length > 0) {
            $("[name='notes']").val(data.notes);
            $("[name='movie']").val(data.movie);
            $("[name='sports']").val(data.sports);
            $("[name='new_program']").val(data.new_program);
            $("[name='program_special']").val(data.program_special);
            $("[name='series']").val(data.series);
        } else {
            clearAllFields();
        }

        loadOutput();
    });
});

// ========== Clear Form ============
function clearAllFields() {
    $("#recapForm textarea").val("");
}

$("#clearForm").click(function(){
    clearAllFields();
});

// ========== Delete Recap ============
$("#deleteRecap").click(function() {
    let tgl = $("#tanggal").val();

    if (!tgl) {
        Swal.fire("Tanggal belum dipilih!");
        return;
    }

    Swal.fire({
        title: "Yakin?",
        text: "Highlight tanggal ini akan dihapus permanen.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Hapus"
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("delete.php", { tanggal: tgl }, function(){
                Swal.fire("Terhapus!", "Data Highlight sudah dihapus.", "success");
                clearAllFields();
                $("#output").text("");
            });
        }
    });
});

// ========== Copy ============
function copyOutput() {
    let text = document.getElementById("output").innerText;
    // let footNote = document.getElementById("footNote").innerText;

    // Coba pakai Clipboard API modern
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(() => {
            Swal.fire("Copied!", "Highlight Competitor sudah disalin.", "success");
        }).catch(err => {
            fallbackCopy(text);
        });
    } else {
        fallbackCopy(text);
    }
}

// Fallback copy untuk browser lama / PC kantor yang membatasi clipboard
function fallbackCopy(text) {
    const textarea = document.createElement("textarea");
    textarea.value = text;
    textarea.style.position = "fixed";  // Tidak menggulirkan halaman
    textarea.style.opacity = "0";
    document.body.appendChild(textarea);
    textarea.focus();
    textarea.select();

    try {
        document.execCommand('copy');
        Swal.fire("Copied!", "Isi Highlight sudah di simpan.", "success");
    } catch (err) {
        Swal.fire("Gagal", "Browser Anda memblokir fungsi Copy.", "error");
    }

    document.body.removeChild(textarea);
}

// ========== POLLING (cek perubahan setiap 5 detik) ==========

// Menyimpan hash terakhir untuk membandingkan
let lastHash = "";
let firstLoad = true;

function checkChanges() {
    let tanggal = $("#tanggal").val();
    if (!tanggal) return;

    $.get("hash.php", { tanggal: tanggal }, function(res){
        let data = typeof res === "string" ? JSON.parse(res) : res;

        if (!firstLoad && data.hash !== lastHash) {
            highlightChange();
            loadOutput(); // update isi
        }

        lastHash = data.hash;
        firstLoad = false;
    });
}

function highlightChange() {
    $("#output").addClass("changed");
    // $("#output").addClass("changed-text");

    setTimeout(() => {
        $("#output").removeClass("changed");
    }, 1500);
}

// Polling tiap 5 detik
setInterval(checkChanges, 5000);

let typingTimer;
let isTyping = false;

function sendTyping() {
    let user = localStorage.getItem("username") || "Pengguna tidak dikenal";
    let tanggal = $("#tanggal").val();

    if (!isTyping) {
        isTyping = true;
        $.post("typing.php", { tanggal, user, action: "typing" });
    }

    clearTimeout(typingTimer);

    typingTimer = setTimeout(() => {
        isTyping = false;
        $.post("typing.php", { tanggal, user, action: "stop" });
    }, 1000);
}

// Saat textarea diketik
$("textarea").on("input", function () {
    sendTyping();
});

function checkTyping() {
    let tanggal = $("#tanggal").val();
    if (!tanggal) return;

    $.get("typing_status.php", { tanggal: tanggal }, function(res){
        let data = typeof res === "string" ? JSON.parse(res) : res;
        $("#typingStatus").text(data.status);
    });
}

setInterval(checkTyping, 1000);

document.addEventListener("DOMContentLoaded", function () {
    let modalEl = document.getElementById('nameModal');
    let nameModal = new bootstrap.Modal(modalEl, { backdrop: 'static', keyboard: false });

    let localName = localStorage.getItem("username") || "";

    // Fungsi memunculkan modal sampai user isi nama
    function askName() {
        nameModal.show();
    }

    // Jika belum ada nama di localStorage → minta nama
    if (!localName) {
        askName();
    } else {
        // Cek session di server, kalau kosong → kirimkan nama LocalStorage
        fetch("check_name.php")
            .then(res => res.json())
            .then(r => {
                if (!r.username) {
                    sendNameToServer(localName);
                }
            });
    }

    // Fungsi kirim nama ke server
    function sendNameToServer(name) {
        fetch("setname.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: "name=" + encodeURIComponent(name)
        }).then(() => {
            console.log("Nama disimpan:", name);
        });
    }

    // Klik tombol "Simpan Nama"
    document.getElementById("saveNameBtn").addEventListener("click", function () {
        let name = document.getElementById("usernameInput").value.trim();

        if (name.length < 2) {
            alert("Nama terlalu pendek.");
            return;
        }

        localStorage.setItem("username", name);
        sendNameToServer(name);

        nameModal.hide();
    });

});
</script>

<footer class="text-center mt-4 mb-2 text-muted">
    © 2025 <a href="mailto:fatih.akmal@mdentertainment.com" class="text-muted link-mail">Fatih Akmal</a> R&D MDTV — All Rights Reserved
</footer>

<!-- Modal Input Nama -->
<div class="modal fade" id="nameModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title">Masukkan Nama Anda</h5>
      </div>
      <div class="modal-body">
        <input type="text" id="usernameInput" class="form-control" placeholder="Nama Anda..." autofocus>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" id="saveNameBtn">Simpan</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>
