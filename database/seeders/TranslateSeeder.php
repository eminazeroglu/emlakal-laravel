<?php

namespace Database\Seeders;

use App\Models\Translate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Schema;

class TranslateSeeder extends Seeder
{
    public function items(): array
    {
        return [
            /*
             * Validator
             * */
            [
                'text' => ':label boş olmaz',
                'key'  => 'validator.RequiredLabel'
            ],
            [
                'text' => 'Zəhmət olmasa boş buraxmayın.',
                'key'  => 'validator.Required'
            ],
            [
                'text' => 'Zəhmət olmasa düzgün :label daxil edin.',
                'key'  => 'validator.CurrentLabel'
            ],
            [
                'text' => 'Zəhmət olmasa email addressini düzgün formatda daxil edin.',
                'key'  => 'validator.Email'
            ],
            [
                'text' => ':label yanlışdır. Zəhmət olmasa yoxlayıb yenidən cəhd edin.',
                'key'  => 'validator.HasNoLabel'
            ],
            [
                'text' => 'Bu :label artıq istifadə olunur.',
                'key'  => 'validator.HasLabel'
            ],
            [
                'text' => 'Bu məlumat artıq istifadə olunur.',
                'key'  => 'validator.Unique'
            ],
            [
                'text' => ':label sistemdə mövcud deyil. Zəhmət olmasa yoxlayıb yenidən cəhd edin.',
                'key'  => 'validator.CheckLabel'
            ],
            [
                'text' => 'Bu dəyər sistemdə mövcud deyil. Zəhmət olmasa yoxlayıb yenidən cəhd edin.',
                'key'  => 'validator.Exists'
            ],
            [
                'text' => 'Ən az :min simvol olmalıdır.',
                'key'  => 'validator.Min'
            ],
            [
                'text' => 'Minimum :min olmalıdır.',
                'key'  => 'validator.MinValue'
            ],
            [
                'text' => 'Ən çox :max simvol olmalıdır.',
                'key'  => 'validator.Max'
            ],
            [
                'text' => 'Maksimum :max olmalıdır.',
                'key'  => 'validator.MaxValue'
            ],
            [
                'text' => ':label uyğun gəlmir.',
                'key'  => 'validator.SameLabel'
            ],
            [
                'text' => 'Şifrələr uyğun gəlmir.',
                'key'  => 'validator.PasswordSame'
            ],
            [
                'text' => 'Məlumat mövçut deyil.',
                'key'  => 'validator.Exists'
            ],
            [
                'text' => ':label məlumat mövçut deyil.',
                'key'  => 'validator.ExistsLabel'
            ],
            [
                'text' => ':label tam rəqəm olmalıdır.',
                'key'  => 'validator.IntLabel'
            ],
            [
                'text' => 'Tam rəqəm olmalıdır.',
                'key'  => 'validator.Integer'
            ],
            [
                'text' => 'Zəhmət olmasa rəqəm daxil edin',
                'key'  => 'validator.Numeric'
            ],
            [
                'text' => 'Zəhmət olmasa şəkil formatını düzgün seçin',
                'key'  => 'validator.Image'
            ],
            [
                'text' => 'Zəhmət olmasa :limitmb-dan çox şəkil yükləməyin',
                'key'  => 'validator.ImageLimit'
            ],
            [
                'text' => 'Zəhmət olmasa telefon nömrəsini düzgün yazin',
                'key'  => 'validator.PhoneFormat'
            ],
            /*
             * Global Datatable
             * */
            [
                'text' => 'Məlumatların listəsi',
                'key'  => 'datatable.Head'
            ],
            [
                'text' => 'Məlumat formu',
                'key'  => 'datatable.FormHead'
            ],
            [
                'text' => 'Hər səhifədə {menu} məlumat göstərilir',
                'key'  => 'datatable.LengthMenu'
            ],
            [
                'text' => 'Məlumat limiti',
                'key'  => 'datatable.DataLimit'
            ],
            [
                'text' => 'Sütunlar',
                'key'  => 'datatable.Columns'
            ],
            [
                'text' => 'Göstərilir {from}  -  {to} / Ümumi məlumat sayı {count}',
                'key'  => 'datatable.PageShow'
            ],
            [
                'text' => 'Ümumi məlumat sayı {count}',
                'key'  => 'datatable.TotalData'
            ],
            [
                'text' => '{max} Ümumi məlumatda axtarıdı',
                'key'  => 'datatable.FilterTotal'
            ],
            [
                'text' => 'Yüklənir',
                'key'  => 'datatable.Loading'
            ],
            [
                'text' => 'Hazırlanır',
                'key'  => 'datatable.Processing'
            ],
            [
                'text' => 'Axtarış',
                'key'  => 'datatable.Search'
            ],
            [
                'text' => 'Axtardığınıza uyğun məlumat tapılmadı',
                'key'  => 'datatable.NoRecordFound'
            ],
            [
                'text' => 'Birinci',
                'key'  => 'datatable.First'
            ],
            [
                'text' => 'Sonuncu',
                'key'  => 'datatable.Last'
            ],
            [
                'text' => 'İrəli',
                'key'  => 'datatable.Next'
            ],
            [
                'text' => 'Əvvəlki',
                'key'  => 'datatable.Previous'
            ],
            /*
             * Global Date
             * */
            [
                'text' => 'Yanvar',
                'key'  => 'date.Month.January'
            ],
            [
                'text' => 'Fevral',
                'key'  => 'date.Month.February'
            ],
            [
                'text' => 'Mart',
                'key'  => 'date.Month.March'
            ],
            [
                'text' => 'Aprel',
                'key'  => 'date.Month.April'
            ],
            [
                'text' => 'May',
                'key'  => 'date.Month.May'
            ],
            [
                'text' => 'İyun',
                'key'  => 'date.Month.June'
            ],
            [
                'text' => 'İyul',
                'key'  => 'date.Month.July'
            ],
            [
                'text' => 'Avqust',
                'key'  => 'date.Month.August'
            ],
            [
                'text' => 'Sentyabr',
                'key'  => 'date.Month.September'
            ],
            [
                'text' => 'Oktyabr',
                'key'  => 'date.Month.October'
            ],
            [
                'text' => 'Noyabr',
                'key'  => 'date.Month.November'
            ],
            [
                'text' => 'Dekabr',
                'key'  => 'date.Month.December'
            ],
            [
                'text' => 'Bazar ertəsi',
                'key'  => 'date.Week.Monday'
            ],
            [
                'text' => 'Çərşənbə axşamı',
                'key'  => 'date.Week.Tuesday'
            ],
            [
                'text' => 'Çərşənbə',
                'key'  => 'date.Week.Wednesday'
            ],
            [
                'text' => 'Cümə axşamı',
                'key'  => 'date.Week.Thursday'
            ],
            [
                'text' => 'Cümə',
                'key'  => 'date.Week.Friday'
            ],
            [
                'text' => 'Şənbə',
                'key'  => 'date.Week.Saturday'
            ],
            [
                'text' => 'Bazar',
                'key'  => 'date.Week.Sunday'
            ],
            [
                'text' => 'Bu gün',
                'key'  => 'date.Day.ToDay'
            ],
            [
                'text' => 'Dünən',
                'key'  => 'date.Day.Yesterday'
            ],
            /*
             * Enums
             * */
            [
                'text' => 'Əməliyyatlar',
                'key'  => 'enum.TableAction'
            ],
            [
                'text' => 'Kişi',
                'key'  => 'enum.Man'
            ],
            [
                'text' => 'Qadın',
                'key'  => 'enum.Woman'
            ],
            [
                'text' => 'Hər iksi',
                'key'  => 'enum.Both'
            ],
            [
                'text' => 'Bəli',
                'key'  => 'enum.Yes'
            ],
            [
                'text' => 'Xeyr',
                'key'  => 'enum.No'
            ],
            [
                'text' => 'Təstiqlənmiş',
                'key'  => 'enum.Confirmed'
            ],
            [
                'text' => 'Təstiqlənməmiş',
                'key'  => 'enum.Unconfirmed'
            ],
            [
                'text' => 'Seç',
                'key'  => 'enum.Select'
            ],
            /*
             * Route Tab
             * */
            [
                'text' => 'Yenilə',
                'key'  => 'routeTab.Reload'
            ],
            [
                'text' => 'Bağla',
                'key'  => 'routeTab.Close'
            ],
            [
                'text' => 'Sağ tərəfdəkiləri bağla',
                'key'  => 'routeTab.RightClose'
            ],
            [
                'text' => 'Hamsını bağla',
                'key'  => 'routeTab.AllClose'
            ],
            /*
             * Notification
             * */
            [
                'text' => 'Xəbərdarlıq',
                'key'  => 'notification.Warning.Title'
            ],
            [
                'text' => 'Məlumatı silmək istədiyinizə əminsiz?',
                'key'  => 'notification.Delete.Description'
            ],
            [
                'text' => 'Bu istifadəçini bloklamaq istədiyinizə əminsiz? İstifadəçi bloklandıqdan sonra sistemə daxil ola bilməyəcək.',
                'key'  => 'notification.UserBlock.Description'
            ],
            [
                'text' => 'Bu istifadəçini blokdan çıxarmaq istədiyinizə əminsiz? İstifadəçi blokdan çıxdıqdan sonra sistemə daxil ola biləçək',
                'key'  => 'notification.UserUnBlock.Description'
            ],
            [
                'text' => 'Bu dili silmək istədiyinizə əminsiz? Dil silindikdə ona aid tərcümələrdə silinəcək',
                'key'  => 'notification.LanguageDelete.Description'
            ],
            [
                'text' => 'Sizin sistemə daxil olmaq üçün səlahiyyətiniz yoxdur.',
                'key'  => 'notification.LoginNotAccess.Description'
            ],
            [
                'text' => 'Məlumatlar yadda saxlanıldı',
                'key'  => 'notification.CreateOrUpdateSuccess.Description'
            ],
            [
                'text' => 'Sizin profiliniz təstiqlənmədiyi üçün sayta daxil ola bilmirsiz. Zəhmət olmasa email addresinizə daxil olub profilinizi təstiqləyin',
                'key'  => 'notification.ProfileNotActive.Description'
            ],
            [
                'text' => 'Sizin profiliniz rəhbərlik tərəfindən bloklanmişdır.',
                'key'  => 'notification.ProfileBlock.Description'
            ],
            [
                'text' => 'Sizin profiliniz təstiqləndi',
                'key'  => 'notification.ProfileAccept.Description'
            ],
            [
                'text' => 'Şəkilin ölçüsü 2MB-dan çox olmamalıdır. {format} formatda olmalıdır.',
                'key'  => 'notification.MaxPhotoUpload.Description'
            ],
            [
                'text' => 'Şifrənizi yeniləmək üçün link email ünvanınıza göndərildi',
                'key'  => 'notification.UserPasswordReset.Description'
            ],
            [
                'text' => 'Sizin sistemə daxil olmaq üçün içazəniz yoxdur.',
                'key'  => 'notification.UserNotAccess.Description'
            ],
            /*
             * Button
             * */
            [
                'text' => 'Daxil ol',
                'key'  => 'button.Login'
            ],
            [
                'text' => 'Qeyd ol',
                'key'  => 'button.Register'
            ],
            [
                'text' => 'Yadda saxla',
                'key'  => 'button.Save'
            ],
            [
                'text' => 'Göndər',
                'key'  => 'button.Send'
            ],
            [
                'text' => 'Yenilə',
                'key'  => 'button.Reload'
            ],
            [
                'text' => 'Mövcud hesaba daxil ol',
                'key'  => 'button.HasLogin'
            ],
            [
                'text' => 'Razıyam',
                'key'  => 'button.Agree'
            ],
            [
                'text' => 'Razıyam deyləm',
                'key'  => 'button.NotAgree'
            ],
            [
                'text' => 'Şəkil seç',
                'key'  => 'button.SelectPhoto'
            ],
            [
                'text' => 'Şəkilləri seç',
                'key'  => 'button.SelectPhotos'
            ],
            [
                'text' => 'Şəkilləri sil',
                'key'  => 'button.RemovePhotos'
            ],
            [
                'text' => 'Şəkil kəs',
                'key'  => 'button.PhotoCrop'
            ],
            [
                'text' => 'Əlavə et',
                'key'  => 'button.Add'
            ],
            [
                'text' => 'Yeni :label əlavə et',
                'key'  => 'button.AddNewLabel'
            ],
            [
                'text' => 'Düzənlə',
                'key'  => 'button.Edit'
            ],
            [
                'text' => 'Sil',
                'key'  => 'button.Delete'
            ],
            [
                'text' => 'Aktivləşdir',
                'key'  => 'button.Activate'
            ],
            [
                'text' => 'Söndür',
                'key'  => 'button.DeActivate'
            ],
            [
                'text' => 'Geri',
                'key'  => 'button.Back'
            ],
            [
                'text' => 'İstifadəçini blokla',
                'key'  => 'button.UserBlock'
            ],
            [
                'text' => 'İstifadəçini blokdan çıxart',
                'key'  => 'button.UserUnBlock'
            ],
            [
                'text' => 'Təstiqlə',
                'key'  => 'button.Verify'
            ],
            [
                'text' => 'Bağla',
                'key'  => 'button.Close'
            ],
            [
                'text' => 'Səlahiyyət əlavə et',
                'key'  => 'button.AddPermission'
            ],
            [
                'text' => 'Axtar',
                'key'  => 'button.Search'
            ],
            [
                'text' => 'Təmizlə',
                'key'  => 'button.Reset'
            ],
            [
                'text' => 'Filtir',
                'key'  => 'button.Filter'
            ],
            [
                'text' => 'Yüklə',
                'key'  => 'button.Download'
            ],
            [
                'text' => 'Dərc et',
                'key'  => 'button.Publish'
            ],
            [
                'text' => 'Qəbul etmə',
                'key'  => 'button.NotAccept'
            ],
            [
                'text' => 'Arxivə göndər',
                'key'  => 'button.SendArchive'
            ],
            [
                'text' => 'Çıxış',
                'key'  => 'button.Logout'
            ],
            [
                'text' => 'Profilim',
                'key'  => 'button.Profile'
            ],
            /*
             * Component
             * */
            [
                'text' => 'Fayl adı',
                'key'  => 'component.FileName'
            ],
            [
                'text' => 'Fayl həcmi',
                'key'  => 'component.FileSize'
            ],
            [
                'text' => 'Zəhmət olmasa :label formatında şəkil yükləyin',
                'key'  => 'component.FileTypeError'
            ],
            /*
             * Login
             * */
            [
                'text' => 'Hesabınıza daxil olun',
                'key'  => 'login.Head.Text'
            ],
            [
                'text' => 'Email',
                'key'  => 'login.Label.Email'
            ],
            [
                'text' => 'Şifrə',
                'key'  => 'login.Label.Password'
            ],
            /*
             * Register
             * */
            [
                'text' => 'Hesab yaratmaq üçün aşağdakı formu doldurun',
                'key'  => 'register.Head.Text'
            ],
            [
                'text' => 'Siz qeydiyyatdan keçdiniz. Profilinizi təstiqləmək üçün zəhmət olmasa email addresinizə gələn təstiq linkinə keçid edin.',
                'key'  => 'register.Head.AfterRegisterText'
            ],
            [
                'text' => 'Email',
                'key'  => 'register.Label.Email'
            ],
            [
                'text' => 'Şifrə',
                'key'  => 'register.Label.Password'
            ],
            [
                'text' => 'Təkrar şifrə',
                'key'  => 'register.Label.RPassword'
            ],
            [
                'text' => 'Adınız',
                'key'  => 'register.Label.Name'
            ],
            [
                'text' => 'Soyadınız',
                'key'  => 'register.Label.Surname'
            ],
            /*
             * Forget Password
             * */
            [
                'text' => 'Qeydiyyatdan keçdiyiniz email addresinizi yazin.',
                'key'  => 'forgetPassword.Head.Text'
            ],
            [
                'text' => 'Email',
                'key'  => 'forgetPassword.Label.Email'
            ],
            /*
             * Reset Password
             * */
            [
                'text' => 'Şifrə',
                'key'  => 'resetPassword.Label.Password'
            ],
            [
                'text' => 'Təkrar şifrə',
                'key'  => 'resetPassword.Label.RPassword'
            ],
            /*
             * CRM Header
             * */
            [
                'text' => 'Şəxsi kabinet',
                'key'  => 'crm.Header.Label.Profile'
            ],
            [
                'text' => 'Ekranı kilitlə',
                'key'  => 'crm.Header.Label.LockScreen'
            ],
            [
                'text' => 'Çıxış',
                'key'  => 'crm.Header.Label.Logout'
            ],
            /*
             * CRM Sidebar
             * */
            [
                'text' => 'Ana səhifə',
                'key'  => 'crm.Sidebar.HomePage'
            ],
            [
                'text' => 'İstifadəçilər',
                'key'  => 'crm.Sidebar.Users'
            ],
            [
                'text' => 'Ayarlar',
                'key'  => 'crm.Sidebar.Setting'
            ],
            [
                'text' => 'Dillər',
                'key'  => 'crm.Sidebar.SettingLanguages'
            ],
            [
                'text' => 'Tərçümələr',
                'key'  => 'crm.Sidebar.SettingTranslates'
            ],
            [
                'text' => 'Səlahiyyətlər',
                'key'  => 'crm.Sidebar.SettingPermissions'
            ],
            [
                'text' => 'Səlahiyyət parametirləri',
                'key'  => 'crm.Sidebar.SettingPermissionsParams'
            ],
            [
                'text' => 'Əsas ayarlar',
                'key'  => 'crm.Sidebar.SettingMain'
            ],
            [
                'text' => 'İş vaxtı',
                'key'  => 'crm.Sidebar.SettingWorkTime'
            ],
            [
                'text' => 'Logo',
                'key'  => 'crm.Sidebar.SettingLogo'
            ],
            [
                'text' => 'Html etiket',
                'key'  => 'crm.Sidebar.SettingHtml'
            ],
            [
                'text' => 'Sosial səhifələr',
                'key'  => 'crm.Sidebar.SettingSocialPage'
            ],
            [
                'text' => 'SEO',
                'key'  => 'crm.Sidebar.SettingSeoMetaTag'
            ],
            [
                'text' => 'Menular',
                'key'  => 'crm.Sidebar.Menus'
            ],
            /*
             * Language Page
             * */
            [
                'text' => 'Tərçümələr',
                'key'  => 'crm.Language.Head.LanguageTranslate'
            ],
            [
                'text' => 'Adı',
                'key'  => 'crm.Language.Table.Name'
            ],
            [
                'text' => 'Kodu',
                'key'  => 'crm.Language.Table.Code'
            ],
            [
                'text' => 'Əməliyyatlar',
                'key'  => 'crm.Language.Table.Action'
            ],
            [
                'text' => 'Sabit sözlər',
                'key'  => 'crm.Language.Table.DefaultWord'
            ],
            [
                'text' => 'Tərçümə ediləcək',
                'key'  => 'crm.Language.Table.Translate'
            ],
            [
                'text' => 'Sistem key-ləri',
                'key'  => 'crm.Language.Table.Key'
            ],
            [
                'text' => 'Adı',
                'key'  => 'crm.Language.Label.Name'
            ],
            [
                'text' => 'Kodu',
                'key'  => 'crm.Language.Label.Code'
            ],
            /*
             * User Page
             * */
            [
                'text' => 'Ad soyad',
                'key'  => 'crm.User.Label.FullName'
            ],
            [
                'text' => 'Email',
                'key'  => 'crm.User.Label.Email'
            ],
            [
                'text' => 'Şifrə',
                'key'  => 'crm.User.Label.Password'
            ],
            [
                'text' => 'Səlahiyyət',
                'key'  => 'crm.User.Label.Permission'
            ],
            [
                'text' => 'Ad',
                'key'  => 'crm.User.Label.Name'
            ],
            [
                'text' => 'Soyad',
                'key'  => 'crm.User.Label.Surname'
            ],
            [
                'text' => 'Səlahiyyət',
                'key'  => 'crm.User.Label.Permission'
            ],
            [
                'text' => 'Mövcud şifrə',
                'key'  => 'crm.User.Label.CurrentPassword'
            ],
            [
                'text' => 'Yeni şifrə',
                'key'  => 'crm.User.Label.NewPassword'
            ],
            [
                'text' => 'Dil',
                'key'  => 'crm.User.Label.Language'
            ],
            [
                'text' => 'Status',
                'key'  => 'crm.User.Label.Status'
            ],
            /*
             * Permission Page
             * */
            [
                'text' => 'Adı',
                'key'  => 'crm.Permission.Table.Name'
            ],
            [
                'text' => 'Əməliyyatlar',
                'key'  => 'crm.Permission.Table.Action'
            ],
            [
                'text' => 'Tam səlahiyyət',
                'key'  => 'crm.Permission.Table.FullAccess'
            ],
            [
                'text' => 'Tam məhdudiyyət',
                'key'  => 'crm.Permission.Table.NotAccess'
            ],
            [
                'text' => 'Baxış',
                'key'  => 'crm.Permission.Table.Read'
            ],
            [
                'text' => 'Yarat',
                'key'  => 'crm.Permission.Table.Create'
            ],
            [
                'text' => 'Düzəliş et',
                'key'  => 'crm.Permission.Table.Edit'
            ],
            [
                'text' => 'Sil',
                'key'  => 'crm.Permission.Table.Delete'
            ],
            [
                'text' => 'Digrə',
                'key'  => 'crm.Permission.Table.Other'
            ],
            [
                'text' => 'Adı',
                'key'  => 'crm.Permission.Label.Name'
            ],
            /*
             * Setting
             * */
            [
                'text' => 'Sistem dili',
                'key'  => 'crm.Setting.Label.SystemLanguage'
            ],
            [
                'text' => 'Ünvan',
                'key'  => 'crm.Setting.Label.Address'
            ],
            [
                'text' => 'Əlaqə emaili',
                'key'  => 'crm.Setting.Label.Email'
            ],
            [
                'text' => 'Əlaqə nömrəsi',
                'key'  => 'crm.Setting.Label.Phone'
            ],
            [
                'text' => 'Xəritə üzrə ünvan',
                'key'  => 'crm.Setting.Label.Map'
            ],
            [
                'text' => 'Həfrə içi',
                'key'  => 'crm.Setting.Label.Weekdays'
            ],
            [
                'text' => 'Şənbə',
                'key'  => 'crm.Setting.Label.Weekend'
            ],
            [
                'text' => 'Bazar',
                'key'  => 'crm.Setting.Label.Sunday'
            ],
            [
                'text' => 'Başlıq üçün logo',
                'key'  => 'crm.Setting.Label.Logo'
            ],
            [
                'text' => 'Alt hissə üçün logo',
                'key'  => 'crm.Setting.Label.FooterLogo'
            ],
            [
                'text' => 'Mobil üçün logo',
                'key'  => 'crm.Setting.Label.MobileLogo'
            ],
            [
                'text' => 'Favicon (Browser başlıqı)',
                'key'  => 'crm.Setting.Label.Favicon'
            ],
            [
                'text' => 'Paylaşım üçün şəkil',
                'key'  => 'crm.Setting.Label.Wallpaper'
            ],
            [
                'text' => 'Admin panel giriş logosu',
                'key'  => 'crm.Setting.Label.AdminLogin'
            ],
            [
                'text' => 'Admin panel esas logo',
                'key'  => 'crm.Setting.Label.AdminMain'
            ],
            [
                'text' => 'head etiketi',
                'key'  => 'crm.Setting.Label.HeadTag'
            ],
            [
                'text' => 'body etiketi',
                'key'  => 'crm.Setting.Label.BodyTag'
            ],
            [
                'text' => 'Icon',
                'key'  => 'crm.Setting.Label.Icon'
            ],
            [
                'text' => 'Link',
                'key'  => 'crm.Setting.Label.Link'
            ],
            [
                'text' => 'Tema rəngi',
                'key'  => 'crm.Setting.Label.ThemeColor'
            ],
            /*
             * Seo
             * */
            [
                'text' => 'Link',
                'key'  => 'crm.SeoMetaTag.Label.Url'
            ],
            [
                'text' => 'Səhifə başlığı',
                'key'  => 'crm.SeoMetaTag.Label.Title'
            ],
            [
                'text' => 'Səhifə açıqlaması',
                'key'  => 'crm.SeoMetaTag.Label.Description'
            ],
            [
                'text' => 'Səhifə üçün acar sözlər',
                'key'  => 'crm.SeoMetaTag.Label.Keywords'
            ],
            [
                'text' => 'Əməliyyatlar',
                'key'  => 'crm.SeoMetaTag.Label.Action'
            ],
            [
                'text' => 'Botlar',
                'key'  => 'crm.SeoMetaTag.Label.Bots'
            ],
            /*
             * Menu Page
             * */
            [
                'text' => 'Adı',
                'key' => 'crm.Menu.Label.Name'
            ],
            [
                'text' => 'Üst menu',
                'key' => 'crm.Menu.Label.Parent'
            ],
            [
                'text' => 'Link',
                'key' => 'crm.Menu.Label.Link'
            ],
            [
                'text' => 'Yerləşmə yeri',
                'key' => 'crm.Menu.Label.Type'
            ],
            [
                'text' => 'Daxili link',
                'key' => 'crm.Menu.Label.Route'
            ],
            [
                'text' => 'Sıra',
                'key' => 'crm.Menu.Label.Position'
            ],
            [
                'text' => 'Əməliyyatlar',
                'key' => 'crm.Menu.Label.Action'
            ],
        ];
    }

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $items = $this->items();
        $model = new Translate();
        $model->truncate();
        foreach ($items as $item):
            if ($item['key'] && $item['text']):
                $model->insert($item);
            endif;
        endforeach;
        Artisan::call('db:seed --class=PermissionSeeder');
        Schema::enableForeignKeyConstraints();
    }
}
