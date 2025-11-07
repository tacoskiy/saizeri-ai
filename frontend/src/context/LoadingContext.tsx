"use client";

import { createContext, useContext, ReactNode } from "react";
import { useLoadingLogic } from "../hooks/useLoadingLogic";

type LoadingContextType = {
  isLoading: boolean;
  open: () => void;
  close: () => void;
};

const LoadingContext = createContext<LoadingContextType | undefined>(undefined);

export const LoadingProvider = ({ children }: { children: ReactNode }) => {
  const { isLoading, open, close } = useLoadingLogic();

  return (
    <LoadingContext.Provider value={{ isLoading, open, close }}>
      {children}
    </LoadingContext.Provider>
  );
};

export const useLoading = (): LoadingContextType => {
  const context = useContext(LoadingContext);
  if (!context) throw new Error("useLoading must be used within LoadingProvider");
  return context;
};


