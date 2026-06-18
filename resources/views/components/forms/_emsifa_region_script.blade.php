<script>
    (function () {
        var apiBases = [
            'https://www.emsifa.com/api-wilayah-indonesia/api',
            'https://emsifa.github.io/api-wilayah-indonesia/api'
        ];

        function normalize(value) {
            return String(value || '').trim().toUpperCase();
        }

        function formatRegionName(value) {
            return String(value || '')
                .toLowerCase()
                .replace(/\b\w/g, function (char) {
                    return char.toUpperCase();
                });
        }

        function buildPlaceholder(select, label, text) {
            select.innerHTML = '';

            var option = document.createElement('option');
            option.value = '';
            option.textContent = text || ('Pilih ' + label);

            select.appendChild(option);
        }

        function resetSelect(select, label) {
            if (!select) {
                return;
            }

            buildPlaceholder(select, label);
            select.disabled = true;
        }

        function setLoading(select, label) {
            if (!select) {
                return;
            }

            buildPlaceholder(select, label, 'Memuat ' + label + '...');
            select.disabled = true;
        }

        function fillOptions(select, items, label) {
            if (!select) {
                return;
            }

            var currentValue = normalize(select.dataset.current || select.value);

            buildPlaceholder(select, label);

            items.forEach(function (item) {
                var option = document.createElement('option');
                option.value = item.name;
                option.textContent = formatRegionName(item.name);
                option.dataset.code = item.id;

                if (currentValue && currentValue === normalize(item.name)) {
                    option.selected = true;
                }

                select.appendChild(option);
            });

            select.disabled = false;
        }

        function getSelectedCode(select) {
            if (!select || !select.selectedOptions.length) {
                return '';
            }

            return select.selectedOptions[0].dataset.code || '';
        }

        function fetchJson(path) {
            var errors = [];

            function tryAt(index) {
                if (index >= apiBases.length) {
                    throw new Error(errors.join(' | ') || 'Semua endpoint gagal diakses');
                }

                return fetch(apiBases[index] + path, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                }).then(function (response) {
                    if (!response.ok) {
                        throw new Error('HTTP ' + response.status);
                    }

                    return response.json();
                }).catch(function (error) {
                    errors.push(apiBases[index] + path + ' -> ' + error.message);
                    return tryAt(index + 1);
                });
            }

            return tryAt(0);
        }

        function attachRegionSelect(root) {
            var province = root.querySelector('[data-emsifa-level="province"]');
            var regency = root.querySelector('[data-emsifa-level="regency"]');
            var district = root.querySelector('[data-emsifa-level="district"]');
            var village = root.querySelector('[data-emsifa-level="village"]');

            if (!province) {
                return;
            }

            function resetAfterProvince() {
                resetSelect(regency, 'Kabupaten / Kota');
                resetSelect(district, 'Kecamatan');
                resetSelect(village, 'Kelurahan');
            }

            function resetAfterRegency() {
                resetSelect(district, 'Kecamatan');
                resetSelect(village, 'Kelurahan');
            }

            function resetAfterDistrict() {
                resetSelect(village, 'Kelurahan');
            }

            function loadVillages() {
                if (!village || !district) {
                    return Promise.resolve();
                }

                var districtCode = getSelectedCode(district);

                if (!districtCode) {
                    resetAfterDistrict();
                    return Promise.resolve();
                }

                setLoading(village, 'Kelurahan');

                return fetchJson('/villages/' + districtCode + '.json')
                    .then(function (items) {
                        fillOptions(village, items, 'Kelurahan');
                    })
                    .catch(function (error) {
                        console.error('Emsifa villages error:', error);
                        buildPlaceholder(village, 'Kelurahan', 'Gagal memuat kelurahan');
                    });
            }

            function loadDistricts() {
                if (!district || !regency) {
                    return Promise.resolve();
                }

                var regencyCode = getSelectedCode(regency);

                if (!regencyCode) {
                    resetAfterRegency();
                    return Promise.resolve();
                }

                setLoading(district, 'Kecamatan');
                resetSelect(village, 'Kelurahan');

                return fetchJson('/districts/' + regencyCode + '.json')
                    .then(function (items) {
                        fillOptions(district, items, 'Kecamatan');

                        if (district.value && village) {
                            return loadVillages();
                        }
                    })
                    .catch(function (error) {
                        console.error('Emsifa districts error:', error);
                        buildPlaceholder(district, 'Kecamatan', 'Gagal memuat kecamatan');
                    });
            }

            function loadRegencies() {
                if (!regency) {
                    return Promise.resolve();
                }

                var provinceCode = getSelectedCode(province);

                if (!provinceCode) {
                    resetAfterProvince();
                    return Promise.resolve();
                }

                setLoading(regency, 'Kabupaten / Kota');
                resetSelect(district, 'Kecamatan');
                resetSelect(village, 'Kelurahan');

                return fetchJson('/regencies/' + provinceCode + '.json')
                    .then(function (items) {
                        fillOptions(regency, items, 'Kabupaten / Kota');

                        if (regency.value && district) {
                            return loadDistricts();
                        }
                    })
                    .catch(function (error) {
                        console.error('Emsifa regencies error:', error);
                        buildPlaceholder(regency, 'Kabupaten / Kota', 'Gagal memuat kabupaten / kota');
                    });
            }

            function loadProvinces() {
                setLoading(province, 'Provinsi');
                resetAfterProvince();

                return fetchJson('/provinces.json')
                    .then(function (items) {
                        fillOptions(province, items, 'Provinsi');

                        if (province.value && regency) {
                            return loadRegencies();
                        }
                    })
                    .catch(function (error) {
                        console.error('Emsifa provinces error:', error);
                        buildPlaceholder(province, 'Provinsi', 'Gagal memuat provinsi');
                    });
            }

            province.addEventListener('change', function () {
                if (regency) {
                    regency.dataset.current = '';
                }
                if (district) {
                    district.dataset.current = '';
                }
                if (village) {
                    village.dataset.current = '';
                }

                loadRegencies();
            });

            if (regency) {
                regency.addEventListener('change', function () {
                    if (district) {
                        district.dataset.current = '';
                    }
                    if (village) {
                        village.dataset.current = '';
                    }

                    loadDistricts();
                });
            }

            if (district) {
                district.addEventListener('change', function () {
                    if (village) {
                        village.dataset.current = '';
                    }

                    loadVillages();
                });
            }

            loadProvinces();
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('[data-emsifa-region]').forEach(attachRegionSelect);
            });
        } else {
            document.querySelectorAll('[data-emsifa-region]').forEach(attachRegionSelect);
        }
    })();
</script>
