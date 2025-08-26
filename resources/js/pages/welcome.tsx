import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

export default function Welcome() {
    return (
        <>
            <Head title="Sistem Manajemen Warga Desa" />
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
                {/* Header */}
                <header className="border-b border-gray-200 bg-white/80 backdrop-blur-sm">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center h-16">
                            <div className="flex items-center space-x-3">
                                <div className="bg-blue-600 text-white p-2 rounded-lg">
                                    🏛️
                                </div>
                                <div>
                                    <h1 className="text-xl font-bold text-gray-900">SiMaDes</h1>
                                    <p className="text-xs text-gray-600">Sistem Manajemen Desa</p>
                                </div>
                            </div>
                            <div className="flex items-center space-x-4">
                                <Link 
                                    href={route('login')} 
                                    className="text-gray-700 hover:text-blue-600 font-medium transition-colors"
                                >
                                    Masuk
                                </Link>
                                <Link href={route('register')}>
                                    <Button className="bg-blue-600 hover:bg-blue-700 text-white px-6">
                                        Daftar
                                    </Button>
                                </Link>
                            </div>
                        </div>
                    </div>
                </header>

                {/* Hero Section */}
                <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                    <div className="text-center">
                        <div className="mb-8">
                            <span className="text-6xl">🏛️</span>
                        </div>
                        <h1 className="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                            <span className="text-blue-600">Sistem Manajemen</span><br />
                            Warga Desa Digital
                        </h1>
                        <p className="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                            Platform terpadu untuk mengelola administrasi desa, pelayanan surat menyurat, 
                            dan komunikasi antar warga dengan sistem yang modern dan efisien.
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link href={route('register')}>
                                <Button size="lg" className="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 text-lg">
                                    🚀 Mulai Sekarang
                                </Button>
                            </Link>
                            <Link href={route('login')}>
                                <Button variant="outline" size="lg" className="border-blue-200 text-blue-700 hover:bg-blue-50 px-8 py-3 text-lg">
                                    📝 Masuk ke Sistem
                                </Button>
                            </Link>
                        </div>
                    </div>

                    {/* Features Grid */}
                    <div className="mt-24 grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div className="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                            <div className="text-3xl mb-4">👥</div>
                            <h3 className="text-lg font-semibold text-gray-900 mb-2">Manajemen Warga</h3>
                            <p className="text-gray-600 text-sm">
                                Kelola data warga secara terpusat dengan informasi lengkap per RT/RW
                            </p>
                        </div>
                        
                        <div className="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                            <div className="text-3xl mb-4">📄</div>
                            <h3 className="text-lg font-semibold text-gray-900 mb-2">Pelayanan Surat</h3>
                            <p className="text-gray-600 text-sm">
                                Ajukan dan kelola surat online dengan alur persetujuan digital
                            </p>
                        </div>
                        
                        <div className="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                            <div className="text-3xl mb-4">📰</div>
                            <h3 className="text-lg font-semibold text-gray-900 mb-2">Berita & Info</h3>
                            <p className="text-gray-600 text-sm">
                                Dapatkan informasi terkini tentang kegiatan dan pengumuman desa
                            </p>
                        </div>
                        
                        <div className="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                            <div className="text-3xl mb-4">📊</div>
                            <h3 className="text-lg font-semibold text-gray-900 mb-2">Laporan & Statistik</h3>
                            <p className="text-gray-600 text-sm">
                                Pantau aktivitas desa dengan dashboard dan laporan komprehensif
                            </p>
                        </div>
                    </div>

                    {/* User Roles */}
                    <div className="mt-20">
                        <h2 className="text-3xl font-bold text-center text-gray-900 mb-12">
                            🎭 Peran Pengguna Sistem
                        </h2>
                        <div className="grid md:grid-cols-2 lg:grid-cols-5 gap-6">
                            <div className="text-center p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                                <div className="text-4xl mb-3">👑</div>
                                <h3 className="font-semibold text-gray-900 mb-2">Super Admin</h3>
                                <p className="text-sm text-gray-600">
                                    Mengelola semua desa dan sistem global
                                </p>
                            </div>
                            
                            <div className="text-center p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                                <div className="text-4xl mb-3">🏛️</div>
                                <h3 className="font-semibold text-gray-900 mb-2">Admin Desa</h3>
                                <p className="text-sm text-gray-600">
                                    Input data warga, berita, dan kelola sistem desa
                                </p>
                            </div>
                            
                            <div className="text-center p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                                <div className="text-4xl mb-3">👨‍💼</div>
                                <h3 className="font-semibold text-gray-900 mb-2">Kepala Desa</h3>
                                <p className="text-sm text-gray-600">
                                    Approval final surat dan monitoring desa
                                </p>
                            </div>
                            
                            <div className="text-center p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                                <div className="text-4xl mb-3">🏘️</div>
                                <h3 className="font-semibold text-gray-900 mb-2">Ketua RT</h3>
                                <p className="text-sm text-gray-600">
                                    Verifikasi surat dan kelola data RT
                                </p>
                            </div>
                            
                            <div className="text-center p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                                <div className="text-4xl mb-3">👨‍👩‍👧‍👦</div>
                                <h3 className="font-semibold text-gray-900 mb-2">Warga</h3>
                                <p className="text-sm text-gray-600">
                                    Ajukan surat dan akses informasi desa
                                </p>
                            </div>
                        </div>
                    </div>

                    {/* CTA Section */}
                    <div className="mt-20 text-center bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-12 text-white">
                        <h2 className="text-3xl font-bold mb-4">
                            🌟 Siap Modernisasi Desa Anda?
                        </h2>
                        <p className="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
                            Bergabunglah dengan ratusan desa yang telah menggunakan sistem digital 
                            untuk pelayanan yang lebih baik dan transparan.
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link href={route('register')}>
                                <Button size="lg" variant="secondary" className="bg-white text-blue-600 hover:bg-gray-50 px-8 py-3">
                                    💫 Daftar Sekarang
                                </Button>
                            </Link>
                            <Link href={route('login')}>
                                <Button size="lg" variant="outline" className="border-white text-white hover:bg-white/10 px-8 py-3">
                                    🔑 Login Sistem
                                </Button>
                            </Link>
                        </div>
                    </div>
                </main>

                {/* Footer */}
                <footer className="border-t border-gray-200 bg-white/50 backdrop-blur-sm mt-20">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        <div className="flex flex-col md:flex-row justify-between items-center">
                            <div className="flex items-center space-x-3 mb-4 md:mb-0">
                                <div className="bg-blue-600 text-white p-2 rounded-lg text-sm">
                                    🏛️
                                </div>
                                <div>
                                    <h3 className="font-semibold text-gray-900">SiMaDes</h3>
                                    <p className="text-sm text-gray-600">Sistem Manajemen Desa Digital</p>
                                </div>
                            </div>
                            <div className="text-center md:text-right">
                                <p className="text-sm text-gray-600">
                                    © 2024 SiMaDes. Melayani dengan teknologi modern.
                                </p>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}