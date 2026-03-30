import 'dart:async';

import 'package:flutter/material.dart';
import 'package:geolocator/geolocator.dart';
import 'package:shared_preferences/shared_preferences.dart';

import 'api_client.dart';
import 'login_screen.dart';
import 'theme.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  final _apiClient = ApiClient();

  Timer? _timer;
  bool _sending = false;
  DateTime? _lastSentAt;
  Position? _lastPosition;
  String _statusText = 'A kovetes indul';
  String _userName = '';
  String _companyName = '';
  String _userRole = '';

  @override
  void initState() {
    super.initState();
    _loadSessionData();
    _startAutoSending();
  }

  Future<void> _loadSessionData() async {
    final prefs = await SharedPreferences.getInstance();
    if (!mounted) {
      return;
    }

    setState(() {
      _userName = prefs.getString('user_name') ?? '';
      _companyName = prefs.getString('company_name') ?? '';
      _userRole = prefs.getString('user_role') ?? '';
    });
  }

  void _startAutoSending() {
    _timer?.cancel();
    _sendPosition(showFeedback: false);
    _timer = Timer.periodic(const Duration(seconds: 10), (_) {
      _sendPosition(showFeedback: false);
    });
  }

  @override
  void dispose() {
    _timer?.cancel();
    super.dispose();
  }

  Future<Position> _getCurrentLocation() async {
    final serviceEnabled = await Geolocator.isLocationServiceEnabled();
    if (!serviceEnabled) {
      throw const ApiException('A helymeghatarozas ki van kapcsolva a keszuleken.');
    }

    var permission = await Geolocator.checkPermission();
    if (permission == LocationPermission.denied) {
      permission = await Geolocator.requestPermission();
    }

    if (permission == LocationPermission.denied) {
      throw const ApiException('A helyhozzaferes engedelyezese szukseges.');
    }

    if (permission == LocationPermission.deniedForever) {
      throw const ApiException('A helyhozzaferes veglegesen le van tiltva.');
    }

    return Geolocator.getCurrentPosition(desiredAccuracy: LocationAccuracy.high);
  }

  Future<void> _sendPosition({required bool showFeedback}) async {
    if (_sending) {
      return;
    }

    setState(() {
      _sending = true;
      _statusText = 'Pozicio kuldese folyamatban...';
    });

    try {
      final prefs = await SharedPreferences.getInstance();
      final token = prefs.getString('token');
      if (token == null) {
        throw const ApiException('A munkamenet lejarhatott. Jelentkezz be ujra.');
      }

      final position = await _getCurrentLocation();
      await _apiClient.sendPosition(
        token: token,
        lat: position.latitude,
        lon: position.longitude,
        speedKmh: position.speed >= 0 ? position.speed * 3.6 : null,
        recordedAt: position.timestamp?.toIso8601String(),
      );

      if (!mounted) {
        return;
      }

      setState(() {
        _lastPosition = position;
        _lastSentAt = DateTime.now();
        _statusText = 'Kapcsolat rendben, a pozicio mentve lett.';
      });

      if (showFeedback) {
        _showMessage('A pozicio sikeresen el lett kuldve.');
      }
    } on ApiException catch (error) {
      if (!mounted) {
        return;
      }

      setState(() {
        _statusText = error.message;
      });

      if (showFeedback) {
        _showMessage(error.message);
      }
    } catch (_) {
      if (!mounted) {
        return;
      }

      setState(() {
        _statusText = 'Varatlan hiba tortent a pozicio kuldese soran.';
      });

      if (showFeedback) {
        _showMessage(_statusText);
      }
    } finally {
      if (mounted) {
        setState(() {
          _sending = false;
        });
      }
    }
  }

  Future<void> _logout() async {
    _timer?.cancel();

    try {
      await _apiClient.logout();
    } catch (_) {
      // Local logout still proceeds if the API call fails.
    }

    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('token');
    await prefs.remove('user_name');
    await prefs.remove('user_email');
    await prefs.remove('company_name');
    await prefs.remove('user_role');

    if (!mounted) {
      return;
    }

    Navigator.pushReplacement(
      context,
      MaterialPageRoute(builder: (_) => const LoginScreen()),
    );
  }

  void _showMessage(String message) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(content: Text(message)),
    );
  }

  String _formatTimestamp(DateTime? value) {
    if (value == null) {
      return 'Meg nem tortent meg kuldes.';
    }

    final local = value.toLocal();
    final month = local.month.toString().padLeft(2, '0');
    final day = local.day.toString().padLeft(2, '0');
    final hour = local.hour.toString().padLeft(2, '0');
    final minute = local.minute.toString().padLeft(2, '0');
    final second = local.second.toString().padLeft(2, '0');
    return '${local.year}.$month.$day $hour:$minute:$second';
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        decoration: buildPageBackground(),
        child: SafeArea(
          child: RefreshIndicator(
            onRefresh: () => _sendPosition(showFeedback: false),
            color: AppColors.primary,
            backgroundColor: AppColors.surfaceLight,
            child: ListView(
              padding: const EdgeInsets.fromLTRB(20, 18, 20, 28),
              children: [
                _Header(
                  userName: _userName,
                  companyName: _companyName,
                  onLogout: _logout,
                ),
                const SizedBox(height: 20),
                Container(
                  padding: const EdgeInsets.all(22),
                  decoration: buildGlassCardDecoration(),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Row(
                        children: [
                          Container(
                            width: 52,
                            height: 52,
                            decoration: BoxDecoration(
                              borderRadius: BorderRadius.circular(18),
                              gradient: const LinearGradient(
                                colors: [AppColors.primary, AppColors.secondary],
                              ),
                            ),
                            child: const Icon(Icons.my_location_rounded, color: Colors.white),
                          ),
                          const SizedBox(width: 16),
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(
                                  'Mobil kovetes',
                                  style: Theme.of(context).textTheme.titleLarge?.copyWith(
                                        fontWeight: FontWeight.w700,
                                      ),
                                ),
                                const SizedBox(height: 4),
                                Text(
                                  _statusText,
                                  style: const TextStyle(color: AppColors.textMuted),
                                ),
                              ],
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 22),
                      Wrap(
                        spacing: 12,
                        runSpacing: 12,
                        children: [
                          _InfoChip(
                            icon: Icons.schedule_rounded,
                            label: 'Utolso kuldes',
                            value: _formatTimestamp(_lastSentAt),
                          ),
                          _InfoChip(
                            icon: Icons.badge_rounded,
                            label: 'Szerepkor',
                            value: _userRole.isEmpty ? 'partner' : _userRole,
                          ),
                        ],
                      ),
                      const SizedBox(height: 18),
                      SizedBox(
                        width: double.infinity,
                        child: ElevatedButton(
                          onPressed: _sending ? null : () => _sendPosition(showFeedback: true),
                          style: buildPrimaryButtonStyle(),
                          child: GradientButtonBackground(
                            child: Padding(
                              padding: const EdgeInsets.symmetric(vertical: 16),
                              child: Center(
                                child: _sending
                                    ? const SizedBox(
                                        width: 22,
                                        height: 22,
                                        child: CircularProgressIndicator(
                                          strokeWidth: 2.4,
                                          color: Colors.white,
                                        ),
                                      )
                                    : const Row(
                                        mainAxisSize: MainAxisSize.min,
                                        children: [
                                          Icon(Icons.send_rounded),
                                          SizedBox(width: 10),
                                          Text(
                                            'Pozicio kuldese most',
                                            style: TextStyle(fontWeight: FontWeight.w700),
                                          ),
                                        ],
                                      ),
                              ),
                            ),
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 18),
                Container(
                  padding: const EdgeInsets.all(22),
                  decoration: buildGlassCardDecoration(),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        'Aktualis helyadatok',
                        style: Theme.of(context).textTheme.titleMedium?.copyWith(
                              fontWeight: FontWeight.w700,
                            ),
                      ),
                      const SizedBox(height: 18),
                      _MetricTile(
                        icon: Icons.place_rounded,
                        label: 'Szelesseg',
                        value: _lastPosition == null
                            ? 'Nincs adat'
                            : _lastPosition!.latitude.toStringAsFixed(6),
                      ),
                      const SizedBox(height: 12),
                      _MetricTile(
                        icon: Icons.explore_rounded,
                        label: 'Hosszusag',
                        value: _lastPosition == null
                            ? 'Nincs adat'
                            : _lastPosition!.longitude.toStringAsFixed(6),
                      ),
                      const SizedBox(height: 12),
                      _MetricTile(
                        icon: Icons.speed_rounded,
                        label: 'Sebesseg',
                        value: _lastPosition == null || _lastPosition!.speed < 0
                            ? 'Nincs adat'
                            : '${(_lastPosition!.speed * 3.6).toStringAsFixed(1)} km/h',
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 18),
                Container(
                  padding: const EdgeInsets.all(22),
                  decoration: buildGlassCardDecoration(),
                  child: const Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        'Kapcsolati megjegyzes',
                        style: TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.w700,
                          color: AppColors.textBase,
                        ),
                      ),
                      SizedBox(height: 12),
                      Text(
                        'A mobil app a webes Laravel backend /api/mobile vegpontjait hasznalja. Android emulatoron a 10.0.2.2 host mutat a helyi fejlesztoi gepre, fizikai eszkozhoz add meg a sajat szerver URL-t a MOBILE_API_BASE_URL dart-define ertekkel.',
                        style: TextStyle(
                          color: AppColors.textMuted,
                          height: 1.5,
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}

class _Header extends StatelessWidget {
  const _Header({
    required this.userName,
    required this.companyName,
    required this.onLogout,
  });

  final String userName;
  final String companyName;
  final VoidCallback onLogout;

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              const Text(
                'Iranyitopult',
                style: TextStyle(
                  color: AppColors.primary,
                  fontWeight: FontWeight.w700,
                ),
              ),
              const SizedBox(height: 6),
              Text(
                userName.isEmpty ? 'Partner felhasznalo' : userName,
                style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                      fontWeight: FontWeight.w800,
                    ),
              ),
              const SizedBox(height: 4),
              Text(
                companyName.isEmpty ? 'UtdijPro mobil kapcsolat' : companyName,
                style: const TextStyle(color: AppColors.textMuted),
              ),
            ],
          ),
        ),
        IconButton(
          onPressed: onLogout,
          style: IconButton.styleFrom(
            backgroundColor: AppColors.surfaceLight.withOpacity(0.8),
            foregroundColor: Colors.white,
          ),
          icon: const Icon(Icons.logout_rounded),
        ),
      ],
    );
  }
}

class _InfoChip extends StatelessWidget {
  const _InfoChip({
    required this.icon,
    required this.label,
    required this.value,
  });

  final IconData icon;
  final String label;
  final String value;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 12),
      decoration: BoxDecoration(
        color: AppColors.surfaceLight.withOpacity(0.85),
        borderRadius: BorderRadius.circular(18),
        border: Border.all(color: AppColors.border),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(icon, size: 18, color: AppColors.primary),
          const SizedBox(width: 10),
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(label, style: const TextStyle(color: AppColors.textMuted, fontSize: 12)),
              const SizedBox(height: 2),
              Text(value, style: const TextStyle(fontWeight: FontWeight.w600)),
            ],
          ),
        ],
      ),
    );
  }
}

class _MetricTile extends StatelessWidget {
  const _MetricTile({
    required this.icon,
    required this.label,
    required this.value,
  });

  final IconData icon;
  final String label;
  final String value;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: AppColors.surfaceLight.withOpacity(0.78),
        borderRadius: BorderRadius.circular(18),
        border: Border.all(color: AppColors.border),
      ),
      child: Row(
        children: [
          Container(
            width: 42,
            height: 42,
            decoration: BoxDecoration(
              color: AppColors.primary.withOpacity(0.14),
              borderRadius: BorderRadius.circular(14),
            ),
            child: Icon(icon, color: AppColors.primary),
          ),
          const SizedBox(width: 14),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(label, style: const TextStyle(color: AppColors.textMuted, fontSize: 12)),
                const SizedBox(height: 4),
                Text(value, style: const TextStyle(fontWeight: FontWeight.w700, fontSize: 16)),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
