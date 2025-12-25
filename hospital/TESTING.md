# TESTING CHECKLIST - RS SEHAT SEJAHTERA

## 1. Authentication Testing
- [ ] Admin login dengan email & password
- [ ] Pasien login dengan ID pendaftaran + phone
- [ ] Pasien login dengan email + password
- [ ] Logout functionality
- [ ] Password hashing verification

## 2. Patient Flow Testing
- [ ] Pendaftaran baru (multi-step form)
- [ ] Generate appointment ID otomatis
- [ ] Generate patient ID otomatis
- [ ] Email notifikasi pendaftaran
- [ ] Patient dashboard accessible
- [ ] View appointment status
- [ ] Upload bukti pembayaran
- [ ] File validation (image only, max 5MB)

## 3. Admin Flow Testing
- [ ] View dashboard statistics
- [ ] View all appointments
- [ ] Filter appointments by status
- [ ] Search appointments
- [ ] Confirm pending appointments
- [ ] Email notifikasi konfirmasi
- [ ] View payment proofs
- [ ] Verify payment
- [ ] Reject payment
- [ ] Check-in patient
- [ ] Check-out patient
- [ ] Cancel appointment

## 4. Doctor Management Testing
- [ ] Add new doctor
- [ ] Generate doctor ID otomatis
- [ ] Edit doctor information
- [ ] Toggle doctor status (active/inactive)
- [ ] Delete doctor (with validation)
- [ ] Doctor list in appointment form

## 5. Email Testing
- [ ] Appointment created email
- [ ] Appointment confirmed email
- [ ] Payment verified email
- [ ] Email formatting & styling

## 6. Security Testing
- [ ] CSRF protection
- [ ] SQL injection prevention (Eloquent)
- [ ] XSS protection (Blade escaping)
- [ ] File upload security
- [ ] Role-based access control
- [ ] Middleware protection

## 7. UI/UX Testing
- [ ] Responsive design (mobile, tablet, desktop)
- [ ] Animations working properly
- [ ] Modal windows functioning
- [ ] Notification system
- [ ] Form validation
- [ ] Loading states
- [ ] Error handling

## 8. Database Testing
- [ ] All migrations run successfully
- [ ] Relationships working correctly
- [ ] Seeders populate data
- [ ] Indexes for performance
- [ ] Cascade deletes working

## 9. Edge Cases
- [ ] Appointment dengan waktu yang sudah lewat
- [ ] Upload file bukan gambar
- [ ] Upload file > 5MB
- [ ] Duplicate appointment
- [ ] Delete doctor dengan appointments
- [ ] Concurrent payment verification