@extends('themes.' . (app(\App\Services\ThemeService::class)->getActiveThemePath() === 'modern' ? 'modern.frontend.layouts.app' : 'default.frontend.layouts.frontend'))
