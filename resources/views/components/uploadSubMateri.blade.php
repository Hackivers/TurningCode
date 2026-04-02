<div class="tittle-uploadsubmateri">
    <div>
        <h4>upload submateri yok, biar ada update baru nih!!...</h4>
        <h5>user newbie nugguin nih, nggk sabar belajar mereka</h5>
    </div>
</div>
<div class="container container-uploadsubmateri">
    <main class="main-uploadsubmateri">
        <div class="wrapper-uploadsubmateri">
            <form class="wrapper-uploadsubmateri" action="/submateri/store" method="POST" id="form-submateri"
                enctype="multipart/form-data">
                @csrf
                <div>
                    <div class="tittle-kategori-submateri select-materi">
                        <div>
                            <h4>pilih main materi apa </h4>
                            <h5>pilih lah berdasarkan main materi yak!!, jangan asal pilih</h5>
                        </div>
                        <div>
                            <select id="mainSelect">
                                <option value="">-- pilih main materi --</option>
                                @foreach ($mainMateris as $main)
                                    <option value="{{ $main->id }}">{{ $main->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="tittle-kategori-submateri select-materi" id="materiWrapper" style="display:none;">
                        <div>
                            <h4>pilih materi apa untuk lanjut buat submateri bau</h4>
                            <h5>pilih lah sesuai kategori materi yang sesuai yak!!...</h5>
                        </div>
                        <div>
                            <select name="materi_id" id="materiSelect" required>
                                <option value="">-- pilih materi --</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="wrapper-desc-submateri" id="formWrapper" style="display:none;">
                    <div>
                        <div class="tittle-kategori-submateri">
                            <div>
                                <h4>isi data yang sesuai</h4>
                                <h5>isi dengan benar dan teliti agar tidak typo</h5>
                            </div>
                        </div>
                        <div class="input">
                            <input type="text" name="title" placeholder="Judul Utama" required>
                            <input type="text" name="subtitle" placeholder="Sub Judul">
                        </div>
                        <div class="input">
                            <input type="text" name="author" placeholder="Author">
                            <input type="file" name="thumbnail">
                        </div>
                        <div class="input">
                            <input type="text" name="meta_title" placeholder="Meta Title">
                            <textarea name="meta_description" placeholder="Meta Description"></textarea>
                        </div>
                        <div class="check-publish">
                            <label class="checkbox">
                                <input type="checkbox" name="is_published" value="1" checked>
                                Publish
                            </label>
                        </div>
                        <div class="wrapper-artikel-submateri">
                            <div class="tittle-kategori-submateri">
                                <div>
                                    <h4>isi artikel yang sesuai</h4>
                                    <h5>isi dengan benar dan teliti agar tidak typo</h5>
                                </div>
                            </div>
                            <div class="toolbar">
                                <button type="button" onclick="addSection('heading')">+ Judul</button>
                                <button type="button" onclick="addSection('subheading')">+ Subjudul</button>
                                <button type="button" onclick="addSection('content')">+ Paragraf</button>
                            </div>
                            <div class="input" id="sections-wrapper"></div>
                            <div>
                                <button type="submit" class="btn-submit">💾 Simpan SubMateri</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>
