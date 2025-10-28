<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }

function requireAuth(): void {
	if (empty($_SESSION['user'])) {
		header('Location: /crud2/auth/login.php');
		exit();
	}
}

function requireRole(string $role): void {
	requireAuth();
	if (($_SESSION['user']['role'] ?? null) !== $role) {
		header('Location: /crud2/index.php?error=unauthorized');
		exit();
	}
}

function requireAnyRole(array $roles): void {
	requireAuth();
	if (!in_array($_SESSION['user']['role'] ?? '', $roles, true)) {
		header('Location: /crud2/index.php?error=unauthorized');
		exit();
	}
}