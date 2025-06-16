<footer style="background: #333; color: white; text-align: center; padding: 40px 20px; margin-top: 50px;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <h3>TOKO GADGET</h3>
            <p>Toko Gadget Terpercaya</p>
            <p>📞 +62 896-5009-0645 | 📧 tokagadget@gmail.com</p>
            <hr style="margin: 20px 0; border-color: #555;">
            <p>&copy; <?= date('Y') ?> TOKAGADGET. All rights reserved.</p>
        </div>
    </footer>

    <!-- jQuery CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <!-- Bootstrap JS CDN (jika diperlukan) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Script untuk konfirmasi hapus
        function confirmDelete(message) {
            return confirm(message || 'Apakah Anda yakin ingin menghapus data ini?');
        }
        
        // Script untuk format rupiah
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(angka);
        }
        
        // Script untuk validasi form
        $(document).ready(function() {
            // Validasi form checkout
            $('form[name="checkout"]').submit(function(e) {
                let nama = $('input[name="nama"]').val();
                let telepon = $('input[name="telepon"]').val();
                
                if (!nama || !telepon) {
                    alert('Harap lengkapi semua data!');
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
</body>
</html>