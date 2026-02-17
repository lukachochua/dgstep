Place seeder image files here so they are committed to git and copied to `storage/app/public` during `db:seed`.

Expected filenames:

- Hero slides:
  - `database/seeders/assets/hero/slide-1.jpg` (or `.jpeg`/`.png`/`.webp`/`.bmp`)
  - `database/seeders/assets/hero/slide-2.jpg` (or supported extension)
  - `database/seeders/assets/hero/slide-3.jpg` (or supported extension)
- Services:
  - `database/seeders/assets/services/pawnshop.jpg` (or supported extension)
  - `database/seeders/assets/services/smb.jpg` (or supported extension)
  - `database/seeders/assets/services/compliance.jpg` (or supported extension)

Notes:

- On seed, files are copied into:
  - `storage/app/public/hero/`
  - `storage/app/public/services/`
- Hero slide `image_path` is auto-resolved from `hero/slide-1..3`.
- Service `image_path` is auto-resolved from `services/<slug>`.
