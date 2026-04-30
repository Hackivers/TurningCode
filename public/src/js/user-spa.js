const issueModal = document.getElementById('issue-report-modal');
        const issueModalCard = issueModal.querySelector('.neo-card');

        window.openIssueReportModal = function() {
            issueModal.style.display = 'flex';
            document.getElementById('issue-report-msg').style.display = 'none';
            document.getElementById('issue-report-form').reset();
            document.getElementById('issue-image-name').textContent = 'Pilih file atau tarik ke sini';
            
            void issueModal.offsetWidth;
            issueModal.style.opacity = '1';
            issueModalCard.style.transform = 'translateY(0)';
        };

        window.closeIssueReportModal = function() {
            issueModal.style.opacity = '0';
            issueModalCard.style.transform = 'translateY(20px)';
            setTimeout(() => {
                issueModal.style.display = 'none';
            }, 300);
        };

        issueModal.addEventListener('click', function(e) {
            if (e.target === issueModal) closeIssueReportModal();
        });

        async function submitIssueReport(e) {
            e.preventDefault();
            const form = e.target;
            const btn = document.getElementById('btn-submit-report');
            const msgBox = document.getElementById('issue-report-msg');
            const fd = new FormData(form);

            btn.innerHTML = "<i class='bx bx-loader-alt bx-spin'></i> Mengirim...";
            btn.disabled = true;
            msgBox.style.display = 'none';

            try {
                const res = await fetch(document.getElementById('issue-report-modal').dataset.reportUrl, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: fd
                });
                const data = await res.json();
                
                msgBox.style.display = 'block';
                if (data.success) {
                    msgBox.style.background = 'rgba(16,185,129,0.1)';
                    msgBox.style.color = '#10b981';
                    msgBox.textContent = data.message || 'Laporan berhasil dikirim!';
                    form.reset();
                    document.getElementById('issue-image-name').textContent = 'Pilih file atau tarik ke sini';
                    setTimeout(closeIssueReportModal, 2000);
                } else {
                    msgBox.style.background = 'rgba(239,68,68,0.1)';
                    msgBox.style.color = '#ef4444';
                    msgBox.textContent = data.message || 'Gagal mengirim laporan';
                }
            } catch (err) {
                msgBox.style.display = 'block';
                msgBox.style.background = 'rgba(239,68,68,0.1)';
                msgBox.style.color = '#ef4444';
                msgBox.textContent = 'Terjadi kesalahan koneksi.';
            } finally {
                btn.innerHTML = "<i class='bx bx-send'></i> Kirim Laporan";
                btn.disabled = false;
            }
        }