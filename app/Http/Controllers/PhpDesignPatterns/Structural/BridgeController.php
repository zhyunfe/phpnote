<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午10:28
 * 桥梁模式
 * 目的：将抽象与现实分离，这样两者可以独立地改变
 *
 * 主要角色：
 * 抽象化角色：定义抽象类的接口并保存一个对实现化对象的引用
 * 修正抽象化角色：扩展抽象化角色，改变和修正父类对抽象化的定义
 * 实现化角色：定义实现类接口，不给出具体的实现，此接口不一定和抽象化角色的接口定义相同，实际上，这两个接口可以完全不同，实现化角色只给出底层操作，而抽象化角色应当只给出基于底层操作的更高一层的操作
 * 具体实现化角色：实现实现划角色接口并定义它的具体实现
 *
 * 优点：
 * 1、分离接口及其实现部分
 * 将Abstraction与Implementor分享有助于降低对实现部分编译时刻的依赖性
 * 2、提高可扩充性
 * 3、实现细节对客户透明
 *
 * 适用场景：
 * 1、如果一个系统需要在构建的抽象化和具体化角色之间增加更多的灵活性，避免在两个层次之间建立静态的联系
 * 2、设计要求实现角色的任何改变不应当影响客户端，或者说实现化角色的改变对客户端是完全透明的
 * 3、一个构件有多于一个抽象化角色和实现化角色，并且系统需要他们之间进行动态的耦合
 * 4、虽然在系统中使用继承是没有问题的，但是由于抽象化角色和具体化角色需要独立变化，设计要求需要独立管理这两者
 */

/**
 * Class Abstraction
 * 抽象化角色
 * 抽象化给出的定义，并保存一个对实现化对象的引用
 */
abstract class Abstraction
{
    /**
     * @var
     * 对实现化对象的引用
     */
    protected $imp;

    public function operation()
    {
        $this->imp->operationImp();
    }
}

/**
 * Class RefinedAbstraction
 * 修正抽象化角色
 * 扩展抽象化角色，改变和修正父类对抽象化的定义
 */
class RefinedAbstraction extends Abstraction
{
    public function __construct(Implementor $imp)
    {
        $this->imp = $imp;
    }

    /**
     * 操作方法在修正抽象化角色中的实现
     */
    public function operation()
    {
        echo 'Refinedabstraction operation';
        $this->imp->operationImp();
    }
}

/**
 * Class Implementor
 * 实现化角色，给出实现化角色的接口，但不给出具体的实现
 */
abstract class Implementor
{
    abstract public function operationImp();
}

/**
 * Class ConcreteImplentorA
 * 具体化角色A，给出实现化角色接口的具体实现
 */
class ConcreteImplentorA extends Implementor
{
    public function operationImp()
    {
        // TODO: Implement operationImp() method.
        echo 'ConcreteImplentorA operation';
    }
}

class ConcreteImplentoeB extends Implementor
{
    public function operationImp()
    {
        // TODO: Implement operationImp() method.
        echo 'ConcreteImplentorB operation';
    }
}

class Test
{
    public function index()
    {
        $abstration = new RefinedAbstraction(new ConcreteImplentorA());
        $abstration->operation();

        $abstration2 = new RefinedAbstraction(new ConcreteImplentoeB());
        $abstration->operation();
    }
}