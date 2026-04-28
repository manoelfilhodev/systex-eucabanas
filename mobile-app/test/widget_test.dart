import 'package:eucabanas_app/main.dart';
import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';

void main() {
  testWidgets('shows login and opens mobile dashboard', (tester) async {
    await tester.pumpWidget(const EucabanasApp());

    expect(find.text('EuCabanas'), findsOneWidget);
    expect(find.text('Entrar'), findsOneWidget);

    await tester.tap(find.byType(FilledButton));
    await tester.pumpAndSettle();

    expect(find.text('Dashboard de abastecimento'), findsOneWidget);
    expect(find.text('Prioridade de compra'), findsOneWidget);
  });
}
