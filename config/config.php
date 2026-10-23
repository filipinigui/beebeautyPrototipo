<?php
/**
 * BeeBeauty - configuração geral.
 * Enquanto o banco não existir, mantenha DEMO_MODE = true:
 * o site usa os dados de includes/demo-data.php.
 */
const DEMO_MODE = true;

// Banco de dados MySQL (usado quando DEMO_MODE = false)
const DB_HOST = 'localhost';
const DB_NAME = 'beebeauty';
const DB_USER = 'root';
const DB_PASS = '';

// Dados do salão (depois podem vir da tabela "settings")
const SITE_NAME    = 'BeeBeauty';
const SITE_ADDRESS = '1/49 Burnett St, Buderim QLD';
const SITE_EMAIL   = 'hello@beebeauty.com.au';
const SITE_PHONE   = '+61 400 000 000';
const SITE_HOURS   = 'Tue to Sat, 9am to 6pm';

// Administrador (demo). Senha de teste: admin123
// Para gerar outra: php -r "echo password_hash('nova-senha', PASSWORD_DEFAULT);"
const ADMIN_USER = 'admin';
const ADMIN_HASH = '$2y$10$ese02fNosM9NYACFTrDM4eHzk49RAsvV18K8Le3RvU4wYO0hehYHe';
