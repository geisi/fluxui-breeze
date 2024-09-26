# Fluxui Breeze

A Laravel Breeze application ported to [Fluxui](https://fluxui.dev/).

## Quick Start

1. Clone the repository:
   ```bash
   git clone git@github.com:geisi/fluxui-breeze.git
   ```

2. Activate Flux Pro:
   ```bash
   composer config http-basic.composer.fluxui.dev YOUR_EMAIL YOUR_FLUX_PRO_LICENSE
   ```

3. Install dependencies:
   ```bash
   npm ci && composer install
   ```

4. Set up Laravel project:
   ```bash
   cp .env.example .env
   php artisan key:generate
   npm run dev
   ```

## Requirements

- PHP 8.x
- Node.js
- Composer
- Flux Pro license

## Support

For issues or questions, please [open an issue](https://github.com/geisi/fluxui-breeze/issues).

## License

This project is licensed under the [MIT License](LICENSE).
