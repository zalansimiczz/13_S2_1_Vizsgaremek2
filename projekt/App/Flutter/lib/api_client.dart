import 'dart:convert';

import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class ApiClient {
  static const String baseUrl = String.fromEnvironment(
    'MOBILE_API_BASE_URL',
    defaultValue: 'http://10.0.2.2:8000/api/mobile',
  );

  Uri _uri(String path) => Uri.parse('$baseUrl$path');

  Future<Map<String, dynamic>> login({
    required String email,
    required String password,
  }) async {
    final response = await http.post(
      _uri('/login'),
      headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
      body: jsonEncode({'email': email, 'password': password}),
    );

    final data = _decodeResponse(response.body);
    if (response.statusCode != 200 || data['success'] != true) {
      throw ApiException(data['message']?.toString() ?? 'Sikertelen bejelentkezes.');
    }

    return data;
  }

  Future<Map<String, dynamic>> sendPosition({
    required String token,
    required double lat,
    required double lon,
    double? speedKmh,
    String? recordedAt,
  }) async {
    final response = await http.post(
      _uri('/positions'),
      headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
      body: jsonEncode({
        'token': token,
        'lat': lat,
        'lon': lon,
        'speed_kmh': speedKmh,
        'recorded_at': recordedAt,
      }),
    );

    final data = _decodeResponse(response.body);
    if (response.statusCode != 200 || data['success'] != true) {
      throw ApiException(data['message']?.toString() ?? 'A pozicio kuldese sikertelen.');
    }

    return data;
  }

  Future<void> logout() async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('token');
    if (token == null) {
      return;
    }

    await http.post(
      _uri('/logout'),
      headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
      body: jsonEncode({'token': token}),
    );
  }

  Map<String, dynamic> _decodeResponse(String body) {
    if (body.isEmpty) {
      return <String, dynamic>{};
    }

    final decoded = jsonDecode(body);
    if (decoded is Map<String, dynamic>) {
      return decoded;
    }

    throw const ApiException('Ervenytelen szervervalasz.');
  }
}

class ApiException implements Exception {
  const ApiException(this.message);

  final String message;

  @override
  String toString() => message;
}
