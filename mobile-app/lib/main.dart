import 'package:flutter/material.dart';

void main() {
  runApp(const EucabanasApp());
}

class EucabanasApp extends StatelessWidget {
  const EucabanasApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'EuCabanas',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(
          seedColor: EucaColors.gold,
          brightness: Brightness.dark,
        ),
        fontFamily: 'Roboto',
        scaffoldBackgroundColor: EucaColors.background,
        useMaterial3: true,
      ),
      home: const LoginPage(),
    );
  }
}

class EucaColors {
  static const background = Color(0xFF0F0D0B);
  static const surface = Color(0xFF181512);
  static const wood = Color(0xFF2A211A);
  static const gold = Color(0xFFC6A56B);
  static const goldLight = Color(0xFFD8B97A);
  static const text = Color(0xFFF5F1E8);
  static const muted = Color(0xFFB8AA96);
  static const danger = Color(0xFFB85C4A);
  static const forest = Color(0xFF1E2D24);
}

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final loginController = TextEditingController(text: 'admin@hotel.local');
  final passwordController = TextEditingController(text: 'password');
  bool remember = true;

  @override
  void dispose() {
    loginController.dispose();
    passwordController.dispose();
    super.dispose();
  }

  void enterDemo() {
    Navigator.of(context).pushReplacement(
      MaterialPageRoute<void>(builder: (_) => const DashboardPage()),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: DecoratedBox(
        decoration: const BoxDecoration(
          gradient: RadialGradient(
            center: Alignment.topLeft,
            radius: 1.4,
            colors: [Color(0x332A211A), EucaColors.background],
          ),
        ),
        child: SafeArea(
          child: Center(
            child: SingleChildScrollView(
              padding: const EdgeInsets.all(24),
              child: ConstrainedBox(
                constraints: const BoxConstraints(maxWidth: 430),
                child: EucaPanel(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.stretch,
                    children: [
                      const BrandHeader(),
                      const SizedBox(height: 32),
                      EucaTextField(
                        controller: loginController,
                        icon: Icons.person_outline,
                        label: 'E-mail',
                      ),
                      const SizedBox(height: 16),
                      EucaTextField(
                        controller: passwordController,
                        icon: Icons.lock_outline,
                        label: 'Senha',
                        obscureText: true,
                      ),
                      const SizedBox(height: 12),
                      CheckboxListTile(
                        contentPadding: EdgeInsets.zero,
                        value: remember,
                        onChanged: (value) {
                          setState(() => remember = value ?? true);
                        },
                        controlAffinity: ListTileControlAffinity.leading,
                        activeColor: EucaColors.gold,
                        title: const Text('Lembrar-me'),
                      ),
                      const SizedBox(height: 16),
                      FilledButton.icon(
                        onPressed: enterDemo,
                        icon: const Icon(Icons.login),
                        label: const Text('Entrar'),
                        style: FilledButton.styleFrom(
                          backgroundColor: EucaColors.gold,
                          foregroundColor: const Color(0xFF1A1208),
                          minimumSize: const Size.fromHeight(54),
                          textStyle: const TextStyle(
                            fontSize: 16,
                            fontWeight: FontWeight.w800,
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ),
          ),
        ),
      ),
    );
  }
}

class DashboardPage extends StatelessWidget {
  const DashboardPage({super.key});

  @override
  Widget build(BuildContext context) {
    final width = MediaQuery.sizeOf(context).width;
    final crossAxisCount = width >= 720 ? 3 : 1;

    return Scaffold(
      appBar: AppBar(
        backgroundColor: EucaColors.background,
        title: const Text('EuCabanas'),
        actions: [
          IconButton(
            tooltip: 'Sincronizar',
            onPressed: () {},
            icon: const Icon(Icons.sync),
          ),
        ],
      ),
      body: ListView(
        padding: const EdgeInsets.all(20),
        children: [
          const Text(
            'Dashboard de abastecimento',
            style: TextStyle(
              color: EucaColors.text,
              fontSize: 26,
              fontWeight: FontWeight.w800,
            ),
          ),
          const SizedBox(height: 6),
          const Text(
            'Visao mobile inicial da operacao diaria.',
            style: TextStyle(color: EucaColors.muted),
          ),
          const SizedBox(height: 20),
          GridView.count(
            crossAxisCount: crossAxisCount,
            crossAxisSpacing: 12,
            mainAxisSpacing: 12,
            childAspectRatio: width >= 720 ? 2.6 : 3.8,
            shrinkWrap: true,
            physics: const NeverScrollableScrollPhysics(),
            children: const [
              StatusCard(
                label: 'Itens ativos',
                value: '20',
                icon: Icons.inventory_2_outlined,
                color: EucaColors.goldLight,
              ),
              StatusCard(
                label: 'Em atencao',
                value: '5',
                icon: Icons.warning_amber_rounded,
                color: EucaColors.gold,
              ),
              StatusCard(
                label: 'Criticos',
                value: '8',
                icon: Icons.priority_high_rounded,
                color: EucaColors.danger,
              ),
            ],
          ),
          const SizedBox(height: 20),
          const Text(
            'Prioridade de compra',
            style: TextStyle(
              color: EucaColors.text,
              fontSize: 18,
              fontWeight: FontWeight.w800,
            ),
          ),
          const SizedBox(height: 12),
          const PurchaseItem(
            name: 'Manteiga 500g',
            family: 'Alimentos',
            quantity: '1',
            status: 'Saldo Critico',
            color: EucaColors.danger,
          ),
          const PurchaseItem(
            name: 'Oleo de soja 900ml',
            family: 'Alimentos',
            quantity: '2',
            status: 'Saldo Critico',
            color: EucaColors.danger,
          ),
          const PurchaseItem(
            name: 'Leite integral 1L',
            family: 'Alimentos',
            quantity: '4',
            status: 'Saldo em Atencao',
            color: EucaColors.gold,
          ),
        ],
      ),
      bottomNavigationBar: NavigationBar(
        backgroundColor: EucaColors.surface,
        indicatorColor: EucaColors.wood,
        selectedIndex: 0,
        destinations: const [
          NavigationDestination(
            icon: Icon(Icons.dashboard_outlined),
            selectedIcon: Icon(Icons.dashboard),
            label: 'Inicio',
          ),
          NavigationDestination(
            icon: Icon(Icons.inventory_2_outlined),
            label: 'Produtos',
          ),
          NavigationDestination(
            icon: Icon(Icons.receipt_long_outlined),
            label: 'Compras',
          ),
        ],
      ),
    );
  }
}

class BrandHeader extends StatelessWidget {
  const BrandHeader({super.key});

  @override
  Widget build(BuildContext context) {
    return const Column(
      children: [
        Icon(Icons.cabin_outlined, color: EucaColors.goldLight, size: 64),
        SizedBox(height: 14),
        Text(
          'EuCabanas',
          style: TextStyle(
            color: EucaColors.text,
            fontSize: 34,
            fontWeight: FontWeight.w800,
          ),
        ),
        SizedBox(height: 8),
        Text(
          'Sistema de gestao operacional',
          style: TextStyle(color: EucaColors.muted),
        ),
      ],
    );
  }
}

class EucaPanel extends StatelessWidget {
  const EucaPanel({required this.child, super.key});

  final Widget child;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: EucaColors.surface.withValues(alpha: .94),
        border: Border.all(color: EucaColors.gold.withValues(alpha: .28)),
        borderRadius: BorderRadius.circular(22),
        boxShadow: const [
          BoxShadow(
            color: Color(0x66000000),
            blurRadius: 42,
            offset: Offset(0, 24),
          ),
        ],
      ),
      child: child,
    );
  }
}

class EucaTextField extends StatelessWidget {
  const EucaTextField({
    required this.controller,
    required this.icon,
    required this.label,
    this.obscureText = false,
    super.key,
  });

  final TextEditingController controller;
  final IconData icon;
  final String label;
  final bool obscureText;

  @override
  Widget build(BuildContext context) {
    return TextField(
      controller: controller,
      obscureText: obscureText,
      decoration: InputDecoration(
        labelText: label,
        prefixIcon: Icon(icon),
        filled: true,
        fillColor: EucaColors.background.withValues(alpha: .72),
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(14),
          borderSide: BorderSide(color: EucaColors.gold.withValues(alpha: .28)),
        ),
        enabledBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(14),
          borderSide: BorderSide(color: EucaColors.gold.withValues(alpha: .28)),
        ),
        focusedBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(14),
          borderSide: const BorderSide(color: EucaColors.gold),
        ),
      ),
    );
  }
}

class StatusCard extends StatelessWidget {
  const StatusCard({
    required this.label,
    required this.value,
    required this.icon,
    required this.color,
    super.key,
  });

  final String label;
  final String value;
  final IconData icon;
  final Color color;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: EucaColors.surface.withValues(alpha: .94),
        border: Border.all(color: EucaColors.gold.withValues(alpha: .28)),
        borderRadius: BorderRadius.circular(18),
        boxShadow: const [
          BoxShadow(
            color: Color(0x44000000),
            blurRadius: 24,
            offset: Offset(0, 12),
          ),
        ],
      ),
      child: Row(
        children: [
          Icon(icon, color: color, size: 32),
          const SizedBox(width: 16),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Text(
                  value,
                  style: const TextStyle(
                    color: EucaColors.text,
                    fontSize: 24,
                    fontWeight: FontWeight.w900,
                  ),
                ),
                Text(
                  label,
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                  style: const TextStyle(color: EucaColors.muted),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}

class PurchaseItem extends StatelessWidget {
  const PurchaseItem({
    required this.name,
    required this.family,
    required this.quantity,
    required this.status,
    required this.color,
    super.key,
  });

  final String name;
  final String family;
  final String quantity;
  final String status;
  final Color color;

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 10),
      child: EucaPanel(
        child: Row(
          children: [
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    name,
                    style: const TextStyle(
                      color: EucaColors.text,
                      fontWeight: FontWeight.w800,
                    ),
                  ),
                  const SizedBox(height: 4),
                  Text(
                    '$family • Qtde $quantity',
                    style: const TextStyle(color: EucaColors.muted),
                  ),
                ],
              ),
            ),
            Container(
              padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
              decoration: BoxDecoration(
                color: color,
                borderRadius: BorderRadius.circular(999),
              ),
              child: Text(
                status,
                style: const TextStyle(
                  color: Colors.white,
                  fontSize: 12,
                  fontWeight: FontWeight.w800,
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
