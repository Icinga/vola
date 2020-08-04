<!-- vola: Icinga Director random import | (c) 2020 Icinga GmbH | GPLv2+ -->

# Vola Director Import Source

~~"Vola" stands for "Voilà!"~~ 😉

"Vola" stands for volatility.
It's a configurable Director import source which yields
a random amount of rows with random values.

## Installation

```bash
wget -qO- https://github.com/Icinga/vola/releases/download/v${VERSION}/vola.tgz |\
tar -xzC /usr/share/icingaweb2/modules
```

## Configuration

Once the vola module has been enabled,
navigate via the menu to "Vola" and add some columns.
(Required permission: config/modules)

After that an import source of type "Random (Vola)"
may be added in the [Director] itself.


[Director]: https://github.com/Icinga/icingaweb2-module-director
