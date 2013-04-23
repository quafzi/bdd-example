# language: de
Funktionalität: RST-Parser
  Um einfach HTML-Seiten erzeugen zu können
  möchte ich RST-Dateien in HTML umwandeln

  Grundlage:
    Gegeben sei eine RST-Zeichenkette

  Szenario: Erzeugung von ul-Listen
    Angenommen das RST enthält eine unnummerierte Liste
    Wenn die HTML-Umwandlung erfolgt
    Dann wird eine ul-Liste erzeugt

  Szenariogrundriss: Erzeugung von Überschriften
    Angenommen die 1. Überschrift ist mit <rst-h1> markiert
    Und die 2. Überschrift ist mit <rst-h2> markiert
    Und die 3. Überschrift ist mit <rst-h3> markiert
    Und die 4. Überschrift ist mit <rst-h2> markiert
    Wenn die HTML-Umwandlung erfolgt
    Dann wird die 1. Überschrift mit "h1" erzeugt
    Und wird die 2. Überschrift mit "h2" erzeugt
    Und wird die 3. Überschrift mit "h3" erzeugt
    Und wird die 4. Überschrift mit "h2" erzeugt

    Beispiele:
      | rst-h1 | rst-h2 | rst-h3 |
      | =      | -      | ~      |
      | =      | #      | ~      |
      | =      | -      | #      |
      | #      | =      | ~      |
      | ~      | #      | '      |
