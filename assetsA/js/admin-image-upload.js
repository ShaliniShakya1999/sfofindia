/**
 * Admin image pick: validate type/size + instant local preview (object URL).
 * Used by CMS homepage, blog, member photo, etc.
 */
(function (w) {
	'use strict';

	var DEFAULT_MAX = 4 * 1024 * 1024;

	function extOk(name) {
		return /\.(jpe?g|png|gif|webp)$/i.test(name || '');
	}

	function typeOk(mime) {
		if (!mime) return true;
		return /^image\/(jpeg|png|gif|webp)$/i.test(mime);
	}

	w.NgomImageUpload = {
		DEFAULT_MAX_BYTES: DEFAULT_MAX,

		validate: function (file, maxBytes) {
			if (!file) {
				return { ok: false, error: 'Koi file select nahi hui.' };
			}
			maxBytes = maxBytes || DEFAULT_MAX;
			if (file.size < 1) {
				return { ok: false, error: 'Khali file.' };
			}
			if (file.size > maxBytes) {
				var mb = (maxBytes / (1024 * 1024)).toFixed(0);
				return { ok: false, error: 'File bahut badi hai — maximum ' + mb + ' MB.' };
			}
			var okExt = extOk(file.name);
			var okMime = typeOk(file.type);
			if (file.type && !okMime && !okExt) {
				return { ok: false, error: 'Sirf JPG, PNG, GIF ya WEBP image chunein.' };
			}
			if (!okExt && !okMime) {
				return { ok: false, error: 'Sirf JPG, PNG, GIF ya WEBP image chunein.' };
			}
			return { ok: true };
		},

		/** Show local preview; call revokePreview when replacing src with server URL. */
		preview: function (file, imgEl) {
			if (!imgEl) return;
			this.revokePreview(imgEl);
			if (!file) {
				imgEl.style.display = 'none';
				return;
			}
			var u = URL.createObjectURL(file);
			imgEl.dataset.ngomObjectUrl = u;
			imgEl.src = u;
			imgEl.style.display = '';
		},

		revokePreview: function (imgEl) {
			if (!imgEl || !imgEl.dataset.ngomObjectUrl) return;
			try {
				URL.revokeObjectURL(imgEl.dataset.ngomObjectUrl);
			} catch (e) {}
			delete imgEl.dataset.ngomObjectUrl;
		},

		/** Common logic to handle file input change, validation, local preview, and fetch upload */
		bindAjaxUploads: function(selector, uploadUrl) {
			var NU = this;
			document.querySelectorAll(selector).forEach(function (fileInput) {
				fileInput.addEventListener('change', function () {
					if (!fileInput.files || !fileInput.files[0]) return;
					var target = fileInput.getAttribute('data-target-input');
					var f = fileInput.files[0];
					var wrap = fileInput.closest('.flex-grow-1');
					var msgEl = wrap ? wrap.querySelector('.cms-img-upload-msg') : null;
					if (msgEl) msgEl.textContent = '';
					
					var maxB = parseInt(fileInput.getAttribute('data-max-bytes') || '4194304', 10);
					var v = NU.validate(f, maxB);
					if (!v.ok) {
						if (msgEl) msgEl.textContent = v.error;
						else alert(v.error);
						fileInput.value = '';
						return;
					}
					
					var prevImg = target ? document.querySelector('[data-preview-for="' + target + '"]') : null;
					var pathInput = target ? document.querySelector('input[name="' + target + '"]') : null;
					
					if (prevImg) NU.preview(f, prevImg);
					
					var fd = new FormData();
					fd.append('image', f);
					fileInput.disabled = true;
					
					fetch(uploadUrl, { method: 'POST', body: fd, credentials: 'same-origin' })
						.then(function (r) { return r.json().then(function (j) { return { ok: r.ok, data: j }; }); })
						.then(function (res) {
							if (!res.ok || !res.data || !res.data.ok) {
								throw new Error((res.data && res.data.error) ? res.data.error : 'Upload failed');
							}
							if (prevImg) NU.revokePreview(prevImg);
							if (pathInput) pathInput.value = res.data.path;
							if (prevImg) {
								prevImg.src = res.data.url;
								prevImg.style.display = '';
							}
						})
						.catch(function (e) {
							if (msgEl) msgEl.textContent = e.message || 'Upload failed';
							else alert(e.message || 'Upload failed');
							if (prevImg) NU.revokePreview(prevImg);
						})
						.finally(function () {
							fileInput.disabled = false;
							fileInput.value = '';
						});
				});
			});
		}
	};
})(window);
