import 'package:flutter/material.dart';

class AppColors {
  static const primary = Color(0xFF0EA5E9);
  static const secondary = Color(0xFF6366F1);
  static const background = Color(0xFF030712);
  static const surface = Color(0xCC0F172A);
  static const surfaceLight = Color(0xFF1E293B);
  static const textBase = Color(0xFFE2E8F0);
  static const textMuted = Color(0xFF94A3B8);
  static const border = Color(0x3338BDF8);
}

ThemeData buildAppTheme() {
  final base = ThemeData.dark(useMaterial3: true);

  return base.copyWith(
    scaffoldBackgroundColor: AppColors.background,
    colorScheme: const ColorScheme.dark(
      primary: AppColors.primary,
      secondary: AppColors.secondary,
      surface: AppColors.surfaceLight,
    ),
    textTheme: base.textTheme.apply(
      bodyColor: AppColors.textBase,
      displayColor: AppColors.textBase,
    ),
    inputDecorationTheme: InputDecorationTheme(
      filled: true,
      fillColor: AppColors.surfaceLight.withOpacity(0.9),
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(18),
        borderSide: const BorderSide(color: AppColors.border),
      ),
      enabledBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(18),
        borderSide: const BorderSide(color: AppColors.border),
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(18),
        borderSide: const BorderSide(color: AppColors.primary),
      ),
      labelStyle: const TextStyle(color: AppColors.textMuted),
      hintStyle: const TextStyle(color: AppColors.textMuted),
    ),
  );
}

BoxDecoration buildGlassCardDecoration() {
  return BoxDecoration(
    color: AppColors.surface,
    borderRadius: BorderRadius.circular(28),
    border: Border.all(color: AppColors.border),
    boxShadow: const [
      BoxShadow(
        color: Color(0x55000000),
        blurRadius: 24,
        offset: Offset(0, 14),
      ),
    ],
  );
}

BoxDecoration buildPageBackground() {
  return const BoxDecoration(
    gradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [
        Color(0xFF020617),
        Color(0xFF071226),
        Color(0xFF0B1120),
      ],
    ),
  );
}

ButtonStyle buildPrimaryButtonStyle() {
  return ElevatedButton.styleFrom(
    backgroundColor: Colors.transparent,
    shadowColor: Colors.transparent,
    foregroundColor: Colors.white,
    padding: const EdgeInsets.symmetric(horizontal: 22, vertical: 16),
    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(18)),
  );
}

class GradientButtonBackground extends StatelessWidget {
  const GradientButtonBackground({super.key, required this.child});

  final Widget child;

  @override
  Widget build(BuildContext context) {
    return Ink(
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          colors: [AppColors.primary, AppColors.secondary],
        ),
        borderRadius: BorderRadius.circular(18),
      ),
      child: child,
    );
  }
}
