#### How use:

When create provider class, extend ExpressiveProvider/BaseProvider

```
class extend ExpressiveProvider\BaseProvider
{
   // This method are needed
   protected function register()
   {
       
   }
}
```

BaseProvide have five methods above:

```
protected function invokables(string $contract, $service)
protected function factory(string $contract, $service)
protected function aliases(string $name, $service)
protected function config(string $name, $configs)
protected function abstractService(string $contract, $service)
```

You register a factories or someone with declarative functions.