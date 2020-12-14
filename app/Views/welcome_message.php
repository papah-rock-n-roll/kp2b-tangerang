<?= $this->extend('public/partials/index') ?>

<?= $this->section('link') ?>
<style>
	html, body, .cover {height:calc(100vh - 68px);width:100%;}
	.particles-js-canvas-el {position:absolute;top:0}
</style>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

	<div class="container text-center py-5" style="position:relative;overflow:hidden;">

		<div id="header__background"><canvas class="particles-js-canvas-el" width="471" height="1094" style="width: 100%; height: 100%;"></canvas></div>

		<h3 class="mb-4">Sistem Informasi<br>Lahan Pertanian Pangan Berkelanjutan (LP2B)</h3>
		<p>Merupakan sistem informasi lahan pertanian pangan berkelanjutan
			dalam rangka membantu dalam mengelola data lahan pertanian pangan berkelanjutan
			untuk terjaganya data dan informasi sehingga dapat dijadikan sebagai bahan untuk analisa dan evaluasi.</p>

		<div class="row card-deck mt-5 justify-content-center">
			<div class="card col-9 col-md-5 col-lg-4 shadow-sm">
				<div class="card-header">
					<h4 class="my-0 font-weight-normal">Peta</h4>
				</div>
				<div class="card-body">
					<img class="img-fluid mb-2" src="/themes/dist/img/maps.svg" width="50%">
					<p class="text-mutted text-sm">Dalam laman ini anda dapat melihat data secara interaktif secara spasial.</p>
					<a class="btn btn-md btn-block btn-primary" href="/maps">Lihat Peta</a>
				</div>
			</div>
			<div class="card col-9 col-md-5 col-lg-4 shadow-sm">
				<div class="card-header">
					<h4 class="my-0 font-weight-normal">Data</h4>
				</div>
				<div class="card-body">
					<img class="img-fluid mb-2" src="/themes/dist/img/table.svg" width="50%">
					<p class="text-mutted text-sm">Dalam laman ini anda dapat mencari data yang kami publish secara tabular.</p>
					<a class="btn btn-md btn-block btn-primary" href="/data">Cari Data</a>
				</div>
			</div>
		</div>

	</div>

<?= $this->endSection() ?>

<?= $this->section('content2') ?>
<div class="container my-4 text-sm">
	<p>Kabupaten Tangerang telah menetapkan Peraturan Daerah Nomor 13 Tahun 2011 tentang Rencana Tata Ruang Wilayah Kabupaten Tangerang Tahun 2011 – 2031. Perda ini mengamanatkan dilindunginya lahan pertanian untuk menjamin kedaulatan pangan secara berkelanjutan. Bentuk perlindungan lahan pertanian tersebut yaitu dengan ditetapkannya kawasan untuk Lahan Pertanian Pangan Berkelanjutan (LP2B) pada beberapa kecamatan, yang dikelompokkan dalam lahan basah dan lahan kering. Perkembangan Revisi RTRW Pemda Kabupaten Tangerang hingga awal tahun 2019 terkait Kawasan Pertanian Pangan Berkelanjutan (KP2B) yaitu Kawasan Pertanian dan Hortikultura direncanakan kurang lebih 13.685 Ha (Tiga Belas Ribu Enam Ratus Delapan Puluh Lima) Hektar, meliputi 9 Kecamatan : Kecamatan Kronjo, Kecamatan Mekar Baru, Kecamatan Sukamulya, Kecamatan Gunung Kaler, Kecamatan Kresek, Kecamatan Mauk, Kecamatan Rajeg, Kecamatan Kemeri dan Kecamatan Sukadiri.</p>

	<p>Ketersediaan data lahan pertanian pangan berkelanjutan yang mencakup data spasial petak lahan sawah, status kepemilikan, profil budidaya sawah yang meliputi produktivitas, pengolahan dan pemasaran hasil pertanian yang lengkap dan akurat merupakan prasyarat penting mewujudkan upaya perlindungan lahan pertanian pangan berkelanjutan sesuai amanat UU 41 tahun 2009. Oleh karena itu pengelolaan data data-data tersebut perlu diarahkan pada tersedianya data dan informasi yang lengkap, akurat, relevan dan konsisten. Jumlah dan jenis data pertanian sangat beragam dan bervariasi dengan ruang lingkup yang berbeda-beda dari mulai level kabupaten, kecamatan, desa/kelurahan terus berjenjang sampai level yang paling kecil yaitu di tingkat petani.  Keberadaan data yang sangat banyak ini akan sangat menyulitkan jika hanya dikelola secara manual, apalagi jika hanya mengandalkan penanganan dalam bentuk non digital. Proses ekstraksi informasi akan membutuhkan waktu yang lama dan cenderung rawan terhadap adanya kesalahan. Oleh karena itu agar dapat meminimalisir kesalahan serta mempercepat proses ekstraksi informasi diperlukan penanganan data dengan sistem digital melalui manajemen database yang terintegrasi. Oleh karena itu, bersamaan dengan tujuan untuk melaksanakan ketentuan Pasal 60 Undang-Undang Nomor 41 Tahun 2009 tentang Perlindungan Lahan Pertanian Pangan Berkelanjutan, maka telah ditetapkan Peraturan Pemerintah No. 25 tahun 2012 tentang Sistem Informasi Lahan Pertanian Pangan Berkelanjutan. Sistem Informasi Lahan Pertanian Pangan Berkelanjutan adalah kesatuan komponen yang terdiri atas kegiatan yang meliputi penyediaan data, penyeragaman, penyimpanan dan pengamanan, pengolahan, pembuatan produk Informasi, penyampaian produk Informasi dan penggunaan Informasi yang terkait satu sama lain, serta penyelenggaraan mekanismenya pada Perlindungan Lahan Pertanian Pangan Berkelanjutan.
	</p>

	<p>Sistem informasi ini adalah hasil kerjasama Dinas Pertanian dan Ketahanan Pangan Kabupaten Tangerang dengan Pusat Pengkajian Perencanaan dan Pengembangan Wilayah (P4W) LPPM IPB.</p>

	<div class="alert alert-info text-sm">
    <h6><i class="icon fas fa-info"></i> Informasi</h6>
    <p>Sistem informasi ini dibangun menggunakan <a href="https://developers.arcgis.com/javascript/" target="_blank">ArcGIS JavaScript API Versi 4.17</a>. API ini mensyaratkan kebutuhan minimal pada pengguna desktop memiliki RAm 8GB dan 1GB kartu grafis. Dan untuk pengguna mobile device disarankan memiliki RAM minimal 2GB dengan rekomendasi 4GB.</p>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= \App\Libraries\Link::script()->particlesjs ?>

<script>
  window.onload = function() {
		particlesJS.load('header__background', 'themes/particles.json', function() {
		  console.log('callback - particles.js config loaded');
		});
  };
</script>

<?= $this->endSection() ?>
