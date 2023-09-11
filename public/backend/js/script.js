$(document).ready(function() {
    // Aktifkan fitur autocomplete pada form input judul
    $('#judul').autocomplete({
      source: function(request, response) {
        // Kirim request ke server untuk mengambil data suggestion
        $.ajax({
          url: 'http://kp.test/dashboard/judul-kp/suggestion',
          dataType: 'json',
          data: {
            q: request.term
          },
          success: function(data) {
            // Menerima response dari server dan menampilkan data sebagai suggestion
            response(data.map(function(item) {
              // Mengembalikan objek yang berisi value dan label untuk setiap suggestion
              return {
                value: item.judul // Value yang akan ditampilkan pada suggestion
              }
            }));
          }
        });
      },
      minLength: 1, // Minimal panjang karakter yang diinput oleh user sebelum mengirim request
      select: function(event, ui) {
        // Aksi yang dilakukan ketika user memilih suggestion
        // Misalnya mengisi field input judul dengan data yang dipilih
        $('#judul').val(ui.item.value);
      }
    });
  });