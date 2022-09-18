<style>
    a {
        text-decoration: none;
        color: cadetblue;
    }
    a:hover {
        color: black;
    }
    .section {
        height: 100vh;
    }
</style>
<div class="wrp container">
    <div class="row mt-3 ">
        <div class="col-md-3">
            <div class="card p-2 sticky-top">
                <div><a href="#intro">Introduction</a></div>
                <div><a href="#blogPost">get BlogPOST</a></div>
            </div>
        </div>
        <div class="col-md">
            <div class="section" id="intro">
                <p>Hallo halo developer :3. Ini adalah halaman dokumentasi yang dapat kalian pahami ketika kalian ingin membuat template blogger dengan ZBLOG.</p>
                <p>Untuk membuat template ini minimal harus memahami apa itu front-end dan teknologinya, karena ini dibuat untuk memudahkan para front-end developer template blogspot.</p>
                <p>Saya membuat Aplikasi ini diambil dari pengalaman, dimana saat saya membuat template untuk blogspot itu sangat susah sekali dan ribet, karena membuat template blogspot ini sangat berbeda sewaktu saat saya belajar dasar dari website.Karena itu saya membuat Aplikasi ini bisa disebut tools.</p>
                <p>Sayangnya kalian tidak bisa memasukan syntax php kedalam source code.</p> 
                <p>Dalam pembuatan template setidaknya harus memahami JavaScript untuk menampilkan data dari tools ini, karena blogspot tidak mendukung bahasa pemrogramman PHP dimana itu PRIMARY bahasa saya dalam dunia teknologi.</p>
                <p>Jadi karena itu dari PHP saya convert otomatis menjadi template base HTML dan JavaScript, dalam pembuatan template dan kamu juga bisa memasukan syntax css dalam form <code>HEAD</code>.</p>
            </div>
            <div class="section" id="blogPost">
                <div><h5>BlogPost</h5></div>
                <p>ini adalah postingan dari blog kalian <br> return <b>{object}</b></p>
                <table class="table bg-light">
                    <tr>
                        <th>key</th>
                        <th>value</th>
                    </tr>
                    <tr>
                        <td>image</td>
                        <td>Link source gambar pertama/thumbnail dari postingan</td>
                    </tr>
                    <tr>
                        <td>JumpLink</td>
                        <td>Link URL postingan</td>
                    </tr>
                    <tr>
                        <td>Content</td>
                        <td>Isi semua postingan.</td>
                    </tr>
                    <tr>
                        <td>Title</td>
                        <td>Judul Postingan</td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td>Tanggal postingan diupload</td>
                    </tr>
                </table>
                example : <code>console.log(blogPost)</code>
            </div>
        </div>
    </div>
</div>