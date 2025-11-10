function tambah(id) {
    var jumlahElemen = document.getElementById(id);
    var nilai = parseInt(jumlahElemen.textContent);
    jumlahElemen.textContent = nilai + 1;
  }
  
  // Fungsi untuk mengurangi jumlah barang
  function kurangi(id) {
    var jumlahElemen = document.getElementById(id);
    var nilai = parseInt(jumlahElemen.textContent);
    if (nilai > 1) {
      jumlahElemen.textContent = nilai - 1;
    }
  }
  
  // Fungsi untuk menambah barang ke keranjang
  function beli(namaProduk, idJumlah) {
    var jumlahElemen = document.getElementById(idJumlah);
    var nilai = parseInt(jumlahElemen.textContent);
    
    var idProduk = idJumlah.replace('jumlah', ''); // Mengambil nomor produk dari idJumlah
    var namaProdukElemen = document.getElementById('namaProduk' + idProduk);
    var namaProduk = namaProdukElemen.textContent;

    var cart = localStorage.getItem('cart') ? JSON.parse(localStorage.getItem('cart')) : {};
    if (cart[namaProduk]) {
        cart[namaProduk] += nilai;
    } else {
        cart[namaProduk] = nilai;
    }
    localStorage.setItem('cart', JSON.stringify(cart));

    alert('Barang ' + namaProduk + ' telah ditambahkan ke keranjang belanja!');
}