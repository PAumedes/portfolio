# Skill: Design Patterns & Refactoring Expert

**Description:** This skill equips the agent with best practices in object-oriented software design, refactoring techniques, and design patterns based on "Dive Into Design Patterns" and "Dive Into Refactoring".

## 1. Core Software Design Principles
When generating or refactoring code, the agent must always evaluate the architecture against these fundamental OOP principles:
* **Encapsulate What Varies:** Identify the aspects of the application that vary and separate them from what stays the same. The main goal of this principle is to minimize the effect caused by changes.
* **Program to an Interface, not an Implementation:** Depend on abstractions, not on concrete classes. The design is flexible enough if you can easily extend it without breaking any existing code.
* **Favor Composition Over Inheritance:** Avoid combinatorial explosions of subclasses by delegating behavior to other objects. This added benefit allows you to replace a behavior at runtime.

## 2. SOLID Principles
Ensure the code strictly adheres to the SOLID principles to make the software design more understandable, flexible, and maintainable:
* **Single Responsibility Principle (SRP):** A class should have just one reason to change. If a class handles multiple disparate behaviors, extract the extra behavior into a separate class.
* **Open/Closed Principle (OCP):** Classes should be open for extension but closed for modification. Instead of changing the code of the class directly, create a subclass and override parts of the original class.
* **Liskov Substitution Principle (LSP):** Subclasses must be substitutable for their base classes. A subclass shouldn't strengthen pre-conditions or weaken post-conditions.
* **Interface Segregation Principle (ISP):** Clients shouldn't be forced to depend on methods they do not use. Split large interfaces into smaller, more specific ones.
* **Dependency Inversion Principle (DIP):** High-level classes shouldn't depend on low-level classes. Both should depend on abstractions.

## 3. Identifying and Resolving Code Smells
The agent should proactively look for signs of "dirty" code and apply appropriate refactoring treatments:
* **Change Preventers:**
    * **Divergent Change:** When you find yourself having to change many methods of a single class for different reasons.
    * **Shotgun Surgery:** When a single change requires making many small changes to many different classes.
* **Dispensables:** Something pointless and unneeded whose absence would make the code cleaner. This includes:
    * **Comments:** When a comment is used to explain complex code (refactor the code to be self-explanatory instead).
    * **Duplicate Code:** Two code fragments look almost identical.
    * **Dead Code:** Variables, parameters, or methods that are no longer used.
    * **Data Class:** Classes that have only fields and getters/setters but no logic.
* **Couplers:**
    * **Feature Envy:** A method accesses the data of another object more than its own data.
    * **Inappropriate Intimacy:** One class uses the internal fields and methods of another class.

## 4. Design Pattern Classifications
Apply patterns based on their intent to solve specific architectural problems:

### Creational Patterns (Object Creation)
* **Factory Method:** Provides an interface for creating objects in a superclass, but allows subclasses to alter the type of objects created.
* **Abstract Factory:** Lets you produce families of related objects without specifying their concrete classes.
* **Builder:** Lets you construct complex objects step by step.
* **Singleton:** Ensures that a class has only one instance, while providing a global access point to this instance.

### Structural Patterns (Object Assembly)
* **Adapter:** Allows objects with incompatible interfaces to collaborate.
* **Composite:** Lets you compose objects into tree structures and then work with these structures as if they were individual objects.
* **Decorator:** Lets you attach new behaviors to objects by placing these objects inside special wrapper objects that contain the behaviors.
* **Facade:** Provides a simplified interface to a library, a framework, or any other complex set of classes.

### Behavioral Patterns (Object Communication)
* **Strategy:** Defines a family of algorithms, puts each of them into a separate class, and makes their objects interchangeable.
* **Observer:** Lets you define a subscription mechanism to notify multiple objects about any events that happen to the object they’re observing.
* **Command:** Turns a request into a stand-alone object that contains all information about the request.
* **State:** Lets an object alter its behavior when its internal state changes. It appears as if the object changed its class.

## 5. Refactoring Workflow
1. **Identify the Smell:** Use the "Code Smells" section to find problematic areas.
2. **Apply Refactoring Technique:** Use techniques like *Extract Method*, *Move Method*, or *Replace Temp with Query*.
3. **Verify Design:** Ensure the refactored code follows SOLID principles and appropriate Design Patterns.
