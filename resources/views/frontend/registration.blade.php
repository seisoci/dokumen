<!DOCTYPE html>
<!--
Template Name: Metronic - Bootstrap 4 HTML, React, Angular 11 & VueJS Admin Dashboard Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: https://1.envato.market/EA4JP
Renew Support: https://1.envato.market/EA4JP
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->

<head>
  <meta charset="utf-8" />
  <title>Pendaftaran Online</title>
  <meta name="description" content="Wizard examples" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
  <link href="{{ asset('css/pages/wizard/wizard-1.css') }}" rel="stylesheet" type="text/css" />
  <!--begin::Fonts-->
  {{ Metronic::getGoogleFontsInclude() }}
  <!--end::Fonts-->

  {{-- Global Theme Styles (used by all pages) --}}
  @foreach(config('layout.resources.css') as $style)
  <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($style)) : asset($style) }}" rel="stylesheet"
    type="text/css" />
  @endforeach

  {{-- Layout Themes (used by all pages) --}}
  @foreach (Metronic::initThemes() as $theme)
  <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($theme)) : asset($theme) }}" rel="stylesheet"
    type="text/css" />
  @endforeach
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
  class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
  <!--begin::Main-->
  <div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">
      <!--begin::Wrapper-->
      <div class="d-flex flex-column flex-row-fluid" id="kt_wrapper">
        <!--begin::Content-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
          <!--begin::Entry-->
          <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
              <div class="card card-custom">
                <div class="card-body p-0">
                  <!--begin::Wizard-->
                  <div class="wizard wizard-1" id="kt_wizard" data-wizard-state="step-first"
                    data-wizard-clickable="false">
                    <!--begin::Wizard Nav-->
                    <div class="wizard-nav border-bottom">
                      <div class="wizard-steps p-8 p-lg-10">
                        <!--begin::Wizard Step 1 Nav-->
                        <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                          <div class="wizard-label">
                            <i class="wizard-icon flaticon-user"></i>
                            <h3 class="wizard-title">1. Data Pribadi</h3>
                          </div>
                          <span class="svg-icon svg-icon-xl wizard-arrow">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                              width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <rect fill="#000000" opacity="0.3"
                                  transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                  x="11" y="5" width="2" height="14" rx="1" />
                                <path
                                  d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                  fill="#000000" fill-rule="nonzero"
                                  transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                              </g>
                            </svg>
                            <!--end::Svg Icon-->
                          </span>
                        </div>
                        <!--end::Wizard Step 1 Nav-->
                        <!--begin::Wizard Step 2 Nav-->
                        <div class="wizard-step" data-wizard-type="step">
                          <div class="wizard-label">
                            <i class="wizard-icon flaticon-list"></i>
                            <h3 class="wizard-title">2. Data Keluarga</h3>
                          </div>
                          <span class="svg-icon svg-icon-xl wizard-arrow">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                              width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <rect fill="#000000" opacity="0.3"
                                  transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                  x="11" y="5" width="2" height="14" rx="1" />
                                <path
                                  d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                  fill="#000000" fill-rule="nonzero"
                                  transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                              </g>
                            </svg>
                            <!--end::Svg Icon-->
                          </span>
                        </div>
                        <!--end::Wizard Step 2 Nav-->
                        <!--begin::Wizard Step 3 Nav-->
                        <div class="wizard-step" data-wizard-type="step">
                          <div class="wizard-label">
                            <i class="wizard-icon flaticon-network"></i>
                            <h3 class="wizard-title">3. Riwayat & Pengalaman Kerja</h3>
                          </div>
                          <span class="svg-icon svg-icon-xl wizard-arrow">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                              width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <rect fill="#000000" opacity="0.3"
                                  transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                  x="11" y="5" width="2" height="14" rx="1" />
                                <path
                                  d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                  fill="#000000" fill-rule="nonzero"
                                  transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                              </g>
                            </svg>
                            <!--end::Svg Icon-->
                          </span>
                        </div>
                        <!--end::Wizard Step 3 Nav-->
                        <!--begin::Wizard Step 4 Nav-->
                        <div class="wizard-step" data-wizard-type="step">
                          <div class="wizard-label">
                            <i class="wizard-icon flaticon-interface-5"></i>
                            <h3 class="wizard-title">4. Kuesioner</h3>
                          </div>
                        </div>
                        <!--end::Wizard Step 4 Nav-->
                      </div>
                    </div>
                    <!--end::Wizard Nav-->
                    <!--begin::Wizard Body-->
                    <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                      <div class="col-xl-12 col-xxl-7">
                        <!--begin::Wizard Form-->
                        <form class="form" id="kt_form">
                          @csrf
                          <!--begin::Wizard Step 1-->
                          <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                            <h3 class="mb-10 font-weight-bold text-dark">Input Data Pribadi dan Upload CV</h3>
                            <div class="row">
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Nama Lengkap</label>
                                  <input type="text" class="form-control form-control-solid form-control-lg"
                                    name="applicant[full_name]" placeholder="Nama Lengkap" />
                                </div>
                              </div>
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Nama Panggilan</label>
                                  <input type="text" class="form-control form-control-solid form-control-lg"
                                    name="applicant[nickname]" placeholder="Nama Panggilan" />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Tempat Lahir</label>
                                  <input type="text" class="form-control form-control-solid form-control-lg"
                                    name="applicant[birthplace]" placeholder="Tempat Lahir" />
                                </div>
                              </div>
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Tanggal Lahir</label>
                                  <input type="text" name="applicant[birthdate]"
                                    class="form-control form-control-solid form-control-lg datepicker"
                                    style="width:100%" readonly placeholder="Tanggal lahir" />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Email</label>
                                  <input type="text" class="form-control form-control-solid form-control-lg"
                                    name="applicant[email]" placeholder="Email" />
                                </div>
                              </div>
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Jenis Kelamin</label>
                                  <select name="applicant[gender]"
                                    class="form-control form-control-solid form-control-lg">
                                    <option value="M">Laki-laki</option>
                                    <option value="F">Perempuan</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Agama</label>
                                  <select name="applicant[religion]"
                                    class="form-control form-control-solid form-control-lg">
                                    <option value="islam">Islam</option>
                                    <option value="protestan">Protestan</option>
                                    <option value="katolik">Katolik</option>
                                    <option value="hindu">Hindu</option>
                                    <option value="buddha">Buddha</option>
                                    <option value="khonghucu">Khonghucu</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Status</label>
                                  <select name="applicant[status]"
                                    class="form-control form-control-solid form-control-lg">
                                    <option value="menikah">Menikah</option>
                                    <option value="belum menikah">Belum Menikah</option>
                                    <option value="cerai">Cerai</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Tinggi Badan</label>
                                  <input type="number" class="form-control form-control-solid form-control-lg"
                                    name="applicant[height]" placeholder="Tinggi Badan" />
                                </div>
                              </div>
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>No Identitas (KTP/SIM)</label>
                                  <input type="text" class="form-control form-control-solid form-control-lg"
                                    name="applicant[no_identity]" placeholder="No Identitas (KTP/SIM)" />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Alamat Sesuai KTP</label>
                                  <input type="text" class="form-control form-control-solid form-control-lg"
                                    name="applicant[address_ktp]" placeholder="Alamat Sesuai KTP" />
                                </div>
                              </div>
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>NPWP</label>
                                  <input type="text" class="form-control form-control-solid form-control-lg"
                                    name="applicant[npwp]" placeholder="NPWP" />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Alamat Tempat Tinggal</label>
                                  <input type="text" class="form-control form-control-solid form-control-lg"
                                    name="applicant[address]" placeholder="Alamat Tempat Tinggal" />
                                </div>
                              </div>
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>No HP</label>
                                  <input type="number" class="form-control form-control-solid form-control-lg"
                                    name="applicant[phone]" placeholder="No HP" />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>No Telepon</label>
                                  <input type="number" class="form-control form-control-solid form-control-lg"
                                    name="applicant[phone_2]" placeholder="No Telepon" />
                                </div>
                              </div>
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Upload CV</label>
                                  <input type="file" name="file" accept="application/pdf" class="form-control-file">
                                  <span>Maksimum 2MB. file pdf</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!--end::Wizard Step 1-->
                          <!--begin::Wizard Step 2-->
                          <div class="pb-5" data-wizard-type="step-content">
                            <h4 class="mb-10 font-weight-bold text-dark">Lengkapi Data Keluarga, Susunan Keluarga dan
                              Kontak Darurat</h4>
                            <!--begin::Input-->
                            <h4 class="text-dark">Data Tanggungan</h4>
                            <div class="row">
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Nama Lengkap</label>
                                  <input type="text" class="form-control form-control-solid form-control-lg"
                                    name="dependents[full_name]" placeholder="Nama Lengkap" /></div>
                              </div>
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Jenis Kelamin</label>
                                  <select name="dependents[gender]"
                                    class="form-control form-control-solid form-control-lg">
                                    <option value="M">Laki-laki</option>
                                    <option value="F">Perempuan</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Hubungan</label>
                                  <select name="dependents[relationship]"
                                    class="form-control form-control-solid form-control-lg">
                                    <option value="suami">Suami</option>
                                    <option value="istri">Istri</option>
                                    <option value="anak">Anak</option>
                                    <option value="ayah">Ayah</option>
                                    <option value="ibu">Ibu</option>
                                    <option value="adik">Adik</option>
                                    <option value="kakak">Kakak</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Pendidikan Terakhir</label>
                                  <select name="dependents[last_education]"
                                    class="form-control form-control-solid form-control-lg">
                                    <option value="sd">SD</option>
                                    <option value="smp">SMP</option>
                                    <option value="sma">SMA</option>
                                    <option value="diploma">Diploma</option>
                                    <option value="sarjana">Sarjana</option>
                                    <option value="magister">Magister</option>
                                    <option value="doktor">Doktor</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <hr>
                            <h4 class="text-dark">Susuan Keluarga Termasuk Anda</h4>
                            <div id="extended_1" class="element">
                              <div class="row">
                                <div class="col-xl-6">
                                  <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control form-control-solid form-control-lg"
                                      name="families[full_name][]" placeholder="Nama Lengkap" />
                                  </div>
                                </div>
                                <div class="col-xl-6">
                                  <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="families[gender][]"
                                      class="form-control form-control-solid form-control-lg">
                                      <option value="M">Laki-laki</option>
                                      <option value="F">Perempuan</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-xl-6">
                                  <div class="form-group">
                                    <label>Hubungan</label>
                                    <select name="families[relationship][]"
                                      class="form-control form-control-solid form-control-lg">
                                      <option value="suami">Suami</option>
                                      <option value="istri">Istri</option>
                                      <option value="anak">Anak</option>
                                      <option value="ayah">Ayah</option>
                                      <option value="ibu">Ibu</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-xl-6">
                                  <div class="form-group">
                                    <label>Pendidikan Terakhir</label>
                                    <select name="families[last_education][]"
                                      class="form-control form-control-solid form-control-lg">
                                      <option value="sd">SD</option>
                                      <option value="smp">SMP</option>
                                      <option value="sma">SMA</option>
                                      <option value="diploma">Diploma</option>
                                      <option value="sarjana">Sarjana</option>
                                      <option value="magister">Magister</option>
                                      <option value="doktor">Doktor</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-xl-6">
                                  <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" class="form-control form-control-solid form-control-lg"
                                      name="families[birthplace][]" placeholder="Tempat Lahir" />
                                  </div>
                                </div>
                                <div class="col-xl-6">
                                  <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="text" name="families[birthdate][]"
                                      class="form-control form-control-solid form-control-lg datepicker"
                                      style="width:100%" readonly placeholder="Tanggal lahir" />
                                  </div>
                                </div>
                              </div>
                              <span class='btn btn-block btn-primary add'>Tambah Keluarga</span>
                            </div>
                            <hr>
                            <h4 class="text-dark">Kontak Darurat</h4>
                            <div class="row">
                              <div class="col-xl-4">
                                <div class="form-group">
                                  <label>Nama</label>
                                  <input type="text" class="form-control form-control-solid form-control-lg"
                                    name="emergency_contacts[full_name]" placeholder="Nama" />
                                </div>
                              </div>
                              <div class="col-xl-4">
                                <div class="form-group">
                                  <label>Hubungan</label>
                                  <select name="emergency_contacts[relationship]"
                                    class="form-control form-control-solid form-control-lg">
                                    <option value="suami">Suami</option>
                                    <option value="istri">Istri</option>
                                    <option value="anak">Anak</option>
                                    <option value="ayah">Ayah</option>
                                    <option value="ibu">Ibu</option>
                                    <option value="adik">Adik</option>
                                    <option value="kakak">Kakak</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-xl-4">
                                <div class="form-group">
                                  <label>No HP</label>
                                  <input type="number" class="form-control form-control-solid form-control-lg"
                                    name="emergency_contacts[phone]" placeholder="No HP" />
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label>Alamat</label>
                              <textarea type="text" rows="3" class="form-control form-control-solid form-control-lg"
                                name="emergency_contacts[address]" placeholder="Alamat"></textarea>
                            </div>
                          </div>
                          <!--end::Wizard Step 2-->
                          <!--begin::Wizard Step 3-->
                          <div class="pb-5" data-wizard-type="step-content">
                            <h4 class="mb-10 font-weight-bold text-dark">Lengkapi Pendidikan, Pengalaman Organisasi,
                              Riwayat Pelatihan, Bahasa Asing, dan Pengalaman Kerja</h4>
                            <!--begin::Select-->
                            <h4 class="text-dark">Riwayat Pendidikan</h4>
                            <div class="row">
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Nama Institusi/Sekolah</label>
                                  <input type="text" class="form-control form-control-solid form-control-lg"
                                    name="education[institution_name]" placeholder="Nama Institusi/Sekolah" /></div>
                              </div>
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Kota/Kabupaten</label>
                                  <input type="text" class="form-control form-control-solid form-control-lg"
                                    name="education[city]" placeholder=Kota/Kabupaten /></div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Jurusan</label>
                                  <input type="text" class="form-control form-control-solid form-control-lg"
                                    name="education[majors]" placeholder="Jurusan" /></div>
                              </div>
                              <div class="col-xl-6">
                                <div class="form-group">
                                  <label>Tahun Kelulusan</label>
                                  <input type="text" name="education[graduation_year]"
                                    class="form-control form-control-solid form-control-lg yeardatepicker"
                                    style="width:100%" readonly placeholder="Tahun Kelulusan" />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-xl-4">
                                <div class="form-group">
                                  <label>IPK</label>
                                  <input type="text" name="education[gpa]"
                                    class="form-control form-control-solid form-control-lg" placeholder="IPK" />
                                </div>
                              </div>
                              <div class="col-xl-8">
                                <div class="form-group">
                                  <label>Apakah anda akan melanjutkan pendidikan ?</label>
                                  <div class="checkbox-inline mt-3">
                                    <label class="checkbox checkbox-square">
                                      <input type="checkbox" checked name="education[continue_education]" value="0">
                                      Tidak</label>
                                    <label class="checkbox checkbox-square">
                                      <input type="checkbox" name="education[continue_education]" value="1">
                                      Ya</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <hr>
                            <h4 class="text-dark">Pengalaman Organisasi</h4>
                            <div class="row">
                              <div class="col-xl-4">
                                <div class="form-group">
                                  <label>Nama Organisasi</label>
                                  <input type="text" name="organizations[name]"
                                    class="form-control form-control-solid form-control-lg"
                                    placeholder="Nama Organisasi" />
                                </div>
                              </div>
                              <div class="col-xl-4">
                                <div class="form-group">
                                  <label>Jabatan</label>
                                  <input type="text" name="organizations[position]"
                                    class="form-control form-control-solid form-control-lg" placeholder="Jabatan" />
                                </div>
                              </div>
                              <div class="col-xl-4">
                                <div class="form-group">
                                  <label>Tahun</label>
                                  <input type="text" name="organizations[year]"
                                    class="form-control form-control-solid form-control-lg yeardatepicker"
                                    style="width:100%" readonly placeholder="Tahun" />
                                </div>
                              </div>
                            </div>
                            <hr>
                            <h4 class="text-dark">Riwayat Pelatihan</h4>
                            <div class="row">
                              <div class="col-xl-4">
                                <div class="form-group">
                                  <label>Nama Pelatihan</label>
                                  <input type="text" name="trainings[name]"
                                    class="form-control form-control-solid form-control-lg"
                                    placeholder="Nama Pelatihan" />
                                </div>
                              </div>
                              <div class="col-xl-4">
                                <div class="form-group">
                                  <label>Tahun</label>
                                  <input type="text" name="trainings[year]"
                                    class="form-control form-control-solid form-control-lg yeardatepicker"
                                    style="width:100%" readonly placeholder="Tahun" />
                                </div>
                              </div>
                              <div class="col-xl-4">
                                <div class="form-group">
                                  <label>Masa Berlaku</label>
                                  <input type="text" name="trainings[expired]"
                                    class="form-control form-control-solid form-control-lg datepicker"
                                    style="width:100%" readonly placeholder="Masa Berlaku" />
                                </div>
                              </div>
                            </div>
                            <hr>
                            <h4 class="text-dark">Bahasa Asing Yang Dikuasi</h4>
                            <div class="form-group">
                              <label>Bahasa Inggris</label>
                              <div class="checkbox-inline mt-3">
                                <input type="checkbox" checked name="foreign_languages[speaking]" style="display:none"
                                  value="0">
                                <label class="checkbox checkbox-square">
                                  <input type="checkbox" name="foreign_languages[speaking]" value="1">
                                  Membaca</label>
                                <input type="checkbox" checked name="foreign_languages[listening]" style="display:none"
                                  value="0">
                                <label class="checkbox checkbox-square">
                                  <input type="checkbox" name="foreign_languages[listening]" value="1">
                                  Mendengar</label>
                                <input type="checkbox" checked name="foreign_languages[writing]" style="display:none"
                                  value="0">
                                <label class="checkbox checkbox-square">
                                  <input type="checkbox" name="foreign_languages[writing]" value="1">
                                  Menulis</label>
                              </div>
                            </div>
                            <hr>
                            <div id="experience_1" class="exp">
                              <h4 class="text-dark">Riwayat Pengalaman Kerja</h4>
                              <div class="row">
                                <div class="col-xl-6">
                                  <div class="form-group">
                                    <label>Nama Perusahaan</label>
                                    <input type="text" class="form-control form-control-solid form-control-lg"
                                      name="work_experiences[name][]" placeholder="Nama Perusahaan" />
                                  </div>
                                </div>
                                <div class="col-xl-6">
                                  <div class="form-group">
                                    <label>Perusahaan Dibidang</label>
                                    <input type="text" class="form-control form-control-solid form-control-lg"
                                      name="work_experiences[sector][]" placeholder="Perusahaan Dibidang" />
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label>Alamat</label>
                                <textarea type="text" rows="3" class="form-control form-control-solid form-control-lg"
                                  name="work_experiences[address][]" placeholder="Alamat"></textarea>
                              </div>
                              <div class="row">
                                <div class="col-xl-6">
                                  <div class="form-group">
                                    <label>Jabatan</label>
                                    <input type="text" class="form-control form-control-solid form-control-lg"
                                      name="work_experiences[position][]" placeholder="Jabatan" />
                                  </div>
                                </div>
                                <div class="col-xl-6">
                                  <div class="form-group">
                                    <label>Gaji</label>
                                    <input type="number" class="form-control form-control-solid form-control-lg"
                                      name="work_experiences[salary][]" placeholder="Gaji" />
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-xl-6">
                                  <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input type="text" name="work_experiences[date_start][]"
                                      class="form-control form-control-solid form-control-lg datepicker"
                                      style="width:100%" readonly placeholder="Tanggal Mulai" />
                                  </div>
                                </div>
                                <div class="col-xl-6">
                                  <div class="form-group">
                                    <label>Tanggal Berakhir</label>
                                    <input type="text" name="work_experiences[date_end][]"
                                      class="form-control form-control-solid form-control-lg datepicker"
                                      style="width:100%" readonly placeholder="Tanggal Berakhir" />
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label>Alasan Berhenti Kerja</label>
                                <textarea type="text" rows="3" class="form-control form-control-solid form-control-lg"
                                  name="work_experiences[resign][]" placeholder="Alasan Berhenti Kerja"></textarea>
                              </div>
                              <span class='btn btn-block btn-primary addExperience'>Tambah Riwayat Pengalaman
                                Kerja</span>
                            </div>
                          </div>
                          <!--end::Wizard Step 3-->
                          <!--begin::Wizard Step 4-->
                          <div class="pb-5" data-wizard-type="step-content">
                            <h4 class="mb-10 font-weight-bold text-dark">Kuisioner</h4>
                            <div class="form-group">
                              <label>1. Darimana anda mengetahui lowongan kerjadi RS.Mitra Husada</label>
                              <input type="text" class="form-control form-control-solid form-control-lg"
                                name="others[answer_1]" placeholder="Jawaban anda" />
                            </div>
                            <div class="form-group">
                              <label>2. Apakah anda pernah melamar kerja di RS.Mitra Husada sebelumnya.Kapan dan posisi
                                apa?</label>
                              <input type="text" class="form-control form-control-solid form-control-lg"
                                name="others[answer_2]" placeholder="Jawaban anda" />
                            </div>
                            <div class="form-group">
                              <label>3. Apakah saat ini anda melamar kerja di perusahaan/rs lain? sebagai posisi
                                apa?</label>
                              <input type="text" class="form-control form-control-solid form-control-lg"
                                name="others[answer_3]" placeholder="Jawaban anda" />
                            </div>
                            <div class="form-group">
                              <label>4. Apakah saat ini anda terikat kontrak dengan perusahaan/rs lain?</label>
                              <input type="text" class="form-control form-control-solid form-control-lg"
                                name="others[answer_4]" placeholder="Jawaban anda" />
                            </div>
                            <div class="form-group">
                              <label>5. Apakah anda memilki pekerjaan part time? dimana dan sebagai apa?</label>
                              <input type="text" class="form-control form-control-solid form-control-lg"
                                name="others[answer_5]" placeholder="Jawaban anda" />
                            </div>
                            <div class="form-group">
                              <label>6. Apakah anda pernah mengalami sakit keras atau menjalani perawatan
                                intensif? Jika iya kapan dan sebutkan penyakitnya?</label>
                              <input type="text" class="form-control form-control-solid form-control-lg"
                                name="others[answer_6]" placeholder="Jawaban anda" />
                            </div>
                            <div class="form-group">
                              <label>7. Apabila diterima, kapan anda mulai bekerja</label>
                              <input type="text" class="form-control form-control-solid form-control-lg"
                                name="others[answer_7]" placeholder="Jawaban anda" />
                            </div>
                            <div class="form-group">
                              <label>8. Berapa besar gaji yang anda harapkan?</label>
                              <input type="text" class="form-control form-control-solid form-control-lg"
                                name="others[answer_8]" placeholder="Jawaban anda" />
                            </div>
                            <div class="form-group">
                              <label>9. Apakah anda mempunyai saudara atau teman yang bekerja di rs.mitra
                                husada</label>
                              <input type="text" class="form-control form-control-solid form-control-lg"
                                name="others[answer_9]" placeholder="Jawaban anda" />
                            </div>
                          </div>
                          <!--end::Wizard Step 4-->
                          <!--begin::Wizard Actions-->
                          <div class="d-flex justify-content-between border-top mt-5 pt-10">
                            <div class="mr-2">
                              <button type="button"
                                class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4"
                                data-wizard-type="action-prev">Previous</button>
                            </div>
                            <div>
                              <button id="submitForm" type="submit"
                                class="btn btn-success font-weight-bolder text-uppercase px-9 py-4"
                                style="display: none;">Submit</button>
                              <button type="button" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4"
                                data-wizard-type="action-next">Next</button>
                            </div>
                          </div>
                          <!--end::Wizard Actions-->
                        </form>
                        <!--end::Wizard Form-->
                      </div>
                    </div>
                    <!--end::Wizard Body-->
                  </div>
                  <!--end::Wizard-->
                </div>
                <!--end::Wizard-->
              </div>
            </div>
            <!--end::Container-->
          </div>
          <!--end::Entry-->
        </div>
        <!--end::Content-->
      </div>
      <!--end::Wrapper-->
    </div>
    <!--end::Page-->
  </div>
  <!--end::Main-->
  <!--begin::Scrolltop-->
  <!--end::Body-->
  <div id="kt_scrolltop" class="scrolltop">
    <span class="svg-icon">
      <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg-->
      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
        viewBox="0 0 24 24" version="1.1">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <polygon points="0 0 24 0 24 24 0 24" />
          <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
          <path
            d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z"
            fill="#000000" fill-rule="nonzero" />
        </g>
      </svg>
      <!--end::Svg Icon-->
    </span>
  </div>
  {{-- Global Config (global config for global JS scripts) --}}
  <script>
    var KTAppSettings = {!! json_encode(config('layout.js'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) !!};
  </script>

  {{-- Global Theme JS Bundle (used by all pages)  --}}
  @foreach(config('layout.resources.js') as $script)
  <script src="{{ asset($script) }}" type="text/javascript"></script>
  @endforeach
  {{-- <script src="{{ asset('js/pages/custom/wizard/wizard-1.js') }}"></script> --}}
  <script>
    $(document).ready(function() {
      var arrows = {
      leftArrow: '<i class="la la-angle-left"></i>',
      rightArrow: '<i class="la la-angle-right"></i>'
      };

      var initDatePicker = function() {
        $('.datepicker').datepicker({
          todayHighlight: true,
          orientation: "bottom left",
          templates: arrows,
          format: 'yyyy-mm-dd',
        });
        $('.yeardatepicker').datepicker({
          todayHighlight: true,
          orientation: "bottom left",
          templates: arrows,
          format: 'yyyy',
          viewMode: "years",
          minViewMode: "years"
        });
      }
      initDatePicker();

      $(".add").click(function(){
        var total_element = $(".element").length;
        var lastid = $(".element:last").attr("id");
        var split_id = lastid.split("_");
        var nextindex = Number(split_id[1]) + 1;
        var max = 5;

        if(total_element < max ){
          $(".element:last").after("<div class='element' id='extended_"+ nextindex +"'></div>");

          $("#extended_" + nextindex).append(data_families(nextindex));
          initDatePicker();
        }
      });

      $('.container').on('click','.remove',function(){
        var id = this.id;
        var split_id = id.split("_");
        var deleteindex = split_id[1];
        $("#extended_" + deleteindex).remove();
      });

      $(".addExperience").click(function(){
        var total_exp = $(".exp").length;
        var lastid = $(".exp:last").attr("id");
        var split_id = lastid.split("_");
        var nextindex = Number(split_id[1]) + 1;
        var max = 5;

        if(total_exp < max ){
          $(".exp:last").after("<div class='exp' id='experience_"+ nextindex +"'></div>");

          $("#experience_" + nextindex).append(data_experience(nextindex));
          initDatePicker();
        }
      });

      $('.container').on('click', '.rmExperience',function(){
        var id = this.id;
        var split_id = id.split("_");
        var deleteindex = split_id[1];
        $("#experience_" + deleteindex).remove();
      });

      $('input[name="education[continue_education]"]').on('change', function() {
        if($('input[name="education[continue_education]"]').prop('checked', true)){
          $('input[name="education[continue_education]"]').not(this).prop('checked', false);
        }
      });

      $('input[name="foreign_languages[listening]"]').on('change', function() {
        if($(this).is(':checked')){
          $('input[name="foreign_languages[listening]"]').not(this).prop('checked', false);
        }else{
          $('input[name="foreign_languages[listening]"]').not(this).prop('checked', true);
        }
      });

      $('input[name="foreign_languages[speaking]"]').on('change', function() {
        if($(this).is(':checked')){
          $('input[name="foreign_languages[speaking]"]').not(this).prop('checked', false);
        }else{
          $('input[name="foreign_languages[speaking]"]').not(this).prop('checked', true);
        }
      });

      $('input[name="foreign_languages[writing]"]').on('change', function() {
        if($(this).is(':checked')){
          $('input[name="foreign_languages[writing]"]').not(this).prop('checked', false);
        }else{
          $('input[name="foreign_languages[writing]"]').not(this).prop('checked', true);
        }
      });

      function data_families(nextindex) {
        return  '<h4 class="text-dark mt-5">Susuan Keluarga Termasuk Anda</h4>'+
        '<div class="row">'+
          ' <div class="col-xl-6">'+
            ' <div class="form-group">'+
              ' <label>Nama Lengkap</label>'+
              ' <input type="text" class="form-control form-control-solid form-control-lg"'+
        ' name="families[full_name][]" placeholder="Nama Lengkap" />'+
              ' </div>'+
            ' </div>'+
          ' <div class="col-xl-6">'+
            ' <div class="form-group">'+
              ' <label>Jenis Kelamin</label>'+
              ' <select name="families[gender][]"'+
        ' class="form-control form-control-solid form-control-lg">'+
                ' <option value="M">Laki-laki</option>'+
                ' <option value="F">Perempuan</option>'+
                ' </select>'+
              ' </div>'+
            ' </div>'+
          '</div>'+
        '<div class="row">'+
          ' <div class="col-xl-6">'+
            ' <div class="form-group">'+
              ' <label>Hubungan</label>'+
              ' <select name="families[relationship][]"'+
        ' class="form-control form-control-solid form-control-lg">'+
                ' <option value="suami">Suami</option>'+
                ' <option value="istri">Istri</option>'+
                ' <option value="anak">Anak</option>'+
                ' <option value="ayah">Ayah</option>'+
                ' <option value="ibu">Ibu</option>'+
                ' </select>'+
              ' </div>'+
            ' </div>'+
          ' <div class="col-xl-6">'+
            ' <div class="form-group">'+
              ' <label>Pendidikan Terakhir</label>'+
              ' <select name="families[last_education][]"'+
        ' class="form-control form-control-solid form-control-lg">'+
                ' <option value="sd">SD</option>'+
                ' <option value="smp">SMP</option>'+
                ' <option value="sma">SMA</option>'+
                ' <option value="diploma">Diploma</option>'+
                ' <option value="sarjana">Sarjana</option>'+
                ' <option value="magister">Magister</option>'+
                ' <option value="doktor">Doktor</option>'+
                ' </select>'+
              ' </div>'+
            ' </div>'+
          '</div>'+
        '<div class="row">'+
          ' <div class="col-xl-6">'+
            ' <div class="form-group">'+
              ' <label>Tempat Lahir</label>'+
              ' <input type="text" class="form-control form-control-solid form-control-lg"'+
        ' name="families[birthplace][]" placeholder="Tempat Lahir" />'+
              ' </div>'+
            ' </div>'+
          ' <div class="col-xl-6">'+
            ' <div class="form-group">'+
              ' <label>Tanggal Lahir</label>'+
              ' <input type="text" name="families[birthdate][]"'+
        ' class="form-control form-control-solid form-control-lg datepicker"'+
        ' style="width:100%" readonly placeholder="Tanggal lahir" />'+
              ' </div>'+
            ' </div>'+
          '</div>' + "<button id='remove_" + nextindex + "' class='btn btn-block btn-danger remove'>Hapus Keluarga</button>";
      };

      function data_experience(nextindex){
        return '<h4 class="text-dark mt-5">Riwayat Pengalaman Kerja</h4>'+
        '<div class="row">'+
          ' <div class="col-xl-6">'+
            ' <div class="form-group">'+
              ' <label>Nama Perusahaan</label>'+
              ' <input type="text" class="form-control form-control-solid form-control-lg"'+
        ' name="work_experiences[name][]" placeholder="Nama Perusahaan" />'+
              ' </div>'+
            ' </div>'+
          ' <div class="col-xl-6">'+
            ' <div class="form-group">'+
              ' <label>Perusahaan Dibidang</label>'+
              ' <input type="text" class="form-control form-control-solid form-control-lg"'+
        ' name="work_experiences[sector][]" placeholder="Perusahaan Dibidang" />'+
              ' </div>'+
            ' </div>'+
          '</div>'+
        '<div class="form-group">'+
          ' <label>Alamat</label>'+
          ' <textarea type="text" rows="3" class="form-control form-control-solid form-control-lg"'+
        ' name="work_experiences[address][]" placeholder="Alamat"></textarea>'+
          '</div>'+
        '<div class="row">'+
          ' <div class="col-xl-6">'+
            ' <div class="form-group">'+
              ' <label>Jabatan</label>'+
              ' <input type="text" class="form-control form-control-solid form-control-lg"'+
        ' name="work_experiences[position][]" placeholder="Jabatan" />'+
              ' </div>'+
            ' </div>'+
          ' <div class="col-xl-6">'+
            ' <div class="form-group">'+
              ' <label>Gaji</label>'+
              ' <input type="number" class="form-control form-control-solid form-control-lg"'+
        ' name="work_experiences[salary][]" placeholder="Gaji" />'+
              ' </div>'+
            ' </div>'+
          '</div>'+
        '<div class="row">'+
          ' <div class="col-xl-6">'+
            ' <div class="form-group">'+
              ' <label>Tanggal Mulai</label>'+
              ' <input type="text" name="work_experiences[date_start][]"'+
        ' class="form-control form-control-solid form-control-lg datepicker"'+
        ' style="width:100%" readonly placeholder="Tanggal Mulai" />'+
              ' </div>'+
            ' </div>'+
          ' <div class="col-xl-6">'+
            ' <div class="form-group">'+
              ' <label>Tanggal Berakhir</label>'+
              ' <input type="text" name="work_experiences[date_end][]"'+
        ' class="form-control form-control-solid form-control-lg datepicker"'+
        ' style="width:100%" readonly placeholder="Tanggal Berakhir" />'+
              ' </div>'+
            ' </div>'+
          '</div>'+
        '<div class="form-group">'+
          ' <label>Alasan Berhenti Kerja</label>'+
          ' <textarea type="text" rows="3" class="form-control form-control-solid form-control-lg"'+
        ' name="work_experiences[resign][]" placeholder="Alasan Berhenti Kerja"></textarea>'+
          '</div>' +
          "<button id='rmExperience_" + nextindex + "' class='btn btn-block btn-danger rmExperience'>Hapus Riwayat Pengalama Kerja</button>";
      }

    var _wizardEl, _formEl, formStore, _wizardObj;
    var _validations = [];
    _wizardEl = KTUtil.getById('kt_wizard');
    _formEl = KTUtil.getById('kt_form');
    formStore = $('#kt_form');

    // Private functions
    var _initValidation = function () {
      // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
      // Step 1
      _validations.push(FormValidation.formValidation(
        _formEl,
        {
          fields: {
            address1: {
              validators: {
                notEmpty: {
                  message: 'Address is required'
                }
              }
            },
            postcode: {
              validators: {
                notEmpty: {
                  message: 'Postcode is required'
                }
              }
            },
            city: {
              validators: {
                notEmpty: {
                  message: 'City is required'
                }
              }
            },
            state: {
              validators: {
                notEmpty: {
                  message: 'State is required'
                }
              }
            },
            country: {
              validators: {
                notEmpty: {
                  message: 'Country is required'
                }
              }
            }
          },
          plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            // Bootstrap Framework Integration
            bootstrap: new FormValidation.plugins.Bootstrap({
              //eleInvalidClass: '',
              eleValidClass: '',
            })
          }
        }
      ));

      // Step 2
      _validations.push(FormValidation.formValidation(
        _formEl,
        {
          fields: {
            package: {
              validators: {
                notEmpty: {
                  message: 'Package details is required'
                }
              }
            },
            weight: {
              validators: {
                notEmpty: {
                  message: 'Package weight is required'
                },
                digits: {
                  message: 'The value added is not valid'
                }
              }
            },
            width: {
              validators: {
                notEmpty: {
                  message: 'Package width is required'
                },
                digits: {
                  message: 'The value added is not valid'
                }
              }
            },
            height: {
              validators: {
                notEmpty: {
                  message: 'Package height is required'
                },
                digits: {
                  message: 'The value added is not valid'
                }
              }
            },
            packagelength: {
              validators: {
                notEmpty: {
                  message: 'Package length is required'
                },
                digits: {
                  message: 'The value added is not valid'
                }
              }
            }
          },
          plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            // Bootstrap Framework Integration
            bootstrap: new FormValidation.plugins.Bootstrap({
              //eleInvalidClass: '',
              eleValidClass: '',
            })
          }
        }
      ));

      // Step 3
      _validations.push(FormValidation.formValidation(
        _formEl,
        {
          fields: {
            delivery: {
              validators: {
                notEmpty: {
                  message: 'Delivery type is required'
                }
              }
            },
            packaging: {
              validators: {
                notEmpty: {
                  message: 'Packaging type is required'
                }
              }
            },
            preferreddelivery: {
              validators: {
                notEmpty: {
                  message: 'Preferred delivery window is required'
                }
              }
            }
          },
          plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            // Bootstrap Framework Integration
            bootstrap: new FormValidation.plugins.Bootstrap({
              //eleInvalidClass: '',
              eleValidClass: '',
            })
          }
        }
      ));

      // Step 4
      _validations.push(FormValidation.formValidation(
        _formEl,
        {
          fields: {
            locaddress1: {
              validators: {
                notEmpty: {
                  message: 'Address is required'
                }
              }
            },
            locpostcode: {
              validators: {
                notEmpty: {
                  message: 'Postcode is required'
                }
              }
            },
            loccity: {
              validators: {
                notEmpty: {
                  message: 'City is required'
                }
              }
            },
            locstate: {
              validators: {
                notEmpty: {
                  message: 'State is required'
                }
              }
            },
            loccountry: {
              validators: {
                notEmpty: {
                  message: 'Country is required'
                }
              }
            }
          },
          plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            // Bootstrap Framework Integration
            bootstrap: new FormValidation.plugins.Bootstrap({
              //eleInvalidClass: '',
              eleValidClass: '',
            })
          }
        }
      ));
    }

      // Initialize form wizard
      _wizardObj = new KTWizard(_wizardEl, {
        startStep: 1, // initial active step number
        clickableSteps: false  // allow step clicking
      });

      // Validation before going to next page
      _wizardObj.on('change', function (wizard) {
        if (wizard.getStep() > wizard.getNewStep()) {
          $('#submitForm').css("display", "none");
          return; // Skip if stepped back
        }

        if(wizard.getNewStep() >= 4){
          $('#submitForm').removeAttr("style");
        }else{
          $('#submitForm').css("display", "none");
        }

        // Validate form before change wizard step
        var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step

        if (validator) {
          validator.validate().then(function (status) {
            if (status == 'Valid') {
              wizard.goTo(wizard.getNewStep());

              KTUtil.scrollTop();
            } else {
              Swal.fire({
                text: "Sorry, looks like there are some errors detected, please try again.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn font-weight-bold btn-light"
                }
              }).then(function () {
                KTUtil.scrollTop();
              });
            }
          });
        }

        return false;  // Do not change wizard step, further action will be handled by he validator
      });

      _wizardObj.on('changed', function (wizard) {
        // KTUtil.scrollTop();
      });


      formStore.on('submit', function(e){
        e.preventDefault();
        var form = $(this);
        var spinner = $('<span role="status" class="spinner-border spinner-border-sm" aria-hidden="true"></span>');
        var url = form.attr("action");
        var data = new FormData(this);
        Swal.fire({
          text: "Pastikan semua form sudah terisi lalu lanjut submit",
          icon: "question",
          showCancelButton: true,
          buttonsStyling: false,
          confirmButtonText: "Yes, submit!",
          cancelButtonText: "No, cancel",
          showLoaderOnConfirm: true,
          customClass: {
            confirmButton: "btn font-weight-bold btn-primary",
            cancelButton: "btn font-weight-bold btn-default"
          },
          preConfirm: (login) => {
            return new Promise(function (resolve) {
              $.ajax({
                cache: false,
                processData: false,
                contentType: false,
                type: "POST",
                data: data,
                success: function(response) {
                  Swal.fire('Sukses', 'Pendaftaran Berhasil', 'success');
                    setTimeout(function(){
                    window.location.href = "/success";
                  }, 2500);
                }
              })
              .done(function (response) {
                console.log(response);
                Swal.fire(response.responseJSON.message);
              })
              .fail(function (response) {
                console.log(response);
                Swal.fire('Error!', 'Lengkapi data yang kosong', 'error');
              })
            })
          },
          allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
        });
      });

    _initValidation();
    });
  </script>

</body>

</html>
